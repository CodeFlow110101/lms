<?php

namespace App\Livewire;

use App\Filament\Pages\Membership;
use Livewire\Component;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Stripe\Stripe;
use Stripe\Price;
use Filament\Notifications\Notification;

class Subscribe extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $data = [];
    public $paymentMethods;
    public $monthly_plan;
    public $yearly_plan;
    public $plans;

    public function mount(): void
    {
        $this->form->fill();
        $this->paymentMethods = Auth::user()->paymentMethods()->map(fn($method) => collect($method->card)->put("id", collect($method)->get("id"))->all())->mapWithKeys(fn($method) => [collect($method)->get('id') => $method]);
        $this->monthly_plan = $this->getDisplayAmount(env("STRIPE_MONTHLY_PLAN_PRICE_ID"));
        $this->yearly_plan = $this->getDisplayAmount(env("STRIPE_YEARLY_PLAN_PRICE_ID"));

        $this->plans = [
            'monthly' => $this->monthly_plan . " (" . $this->monthly_plan . "/month)",
            'yearly' => $this->yearly_plan . " (" . number_format((int)$this->yearly_plan / 12, 2) . " " . Str::of($this->yearly_plan)->replaceMatches('/[^A-Za-z]/', '')->upper()->value() . "/month)",
        ];
    }

    public function getDisplayAmount(string $priceId): string
    {
        Stripe::setApiKey(config('cashier.secret'));

        $price = Price::retrieve($priceId);

        // Convert amount from cents to real value
        $amount = $price->unit_amount / 100;

        // Currency in uppercase (e.g., "INR", "USD")
        $currency = strtoupper($price->currency);
        return $amount . " " . $currency;
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Plan')
                        ->schema([
                            RadioDeck::make('plan')
                                ->options([
                                    'monthly' => 'Monthly',
                                    'yearly' => 'Yearly',
                                ])
                                ->descriptions(fn() => $this->plans)
                                ->required()
                                ->iconPosition(IconPosition::Before) // Before | After
                                ->alignment(Alignment::Center) // Start | Center | End
                                ->colors('primary')
                                ->columns(2)
                                ->columnSpanFull()
                        ]),
                    Step::make('Payment Method')
                        ->schema([
                            RadioDeck::make('payment_method')
                                ->label("Select a payment method")
                                ->options(fn() => $this->paymentMethods->mapWithKeys(fn($method) => [$method['id'] => Str::headline($method['brand'])]))
                                ->descriptions(fn() => $this->paymentMethods->mapWithKeys(fn($method) => [$method['id'] => "**** **** **** " . $method['last4']]))->columns(1)
                                ->required()
                                ->columnSpanFull()
                        ]),
                    Step::make('Confirmation')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Text::make(fn(Get $get) => "Plan: " . Str::headline($get('plan')))->color('neutral'),
                                    Text::make(fn(Get $get) => "Payment Method: "  . Str::headline(Auth::user()->findPaymentMethod($get('payment_method') ? $get('payment_method') : '')?->card->brand) . " (**** **** **** " . Auth::user()->findPaymentMethod($get('payment_method') ? $get('payment_method') : '')?->card->last4 . ")")->color('neutral'),
                                ])
                        ]),
                ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Subscribe
                    </x-filament::button>
                BLADE)))
                    ->skippable(true)
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        Auth::user()->newSubscription(
            $data["plan"],
            getPlanPriceId($data["plan"])
        )->create($data["payment_method"]);

        Notification::make()
            ->title('Subscribed successfully')
            ->success()
            ->send();

        $this->redirect(Membership::getUrl(), navigate: true);
    }

    public function render()
    {
        return view('livewire.subscribe');
    }
}
