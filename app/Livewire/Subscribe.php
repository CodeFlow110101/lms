<?php

namespace App\Livewire;

use App\Filament\Pages\Membership;
use App\Filament\Resources\Posts\PostResource;
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
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Action;

class Subscribe extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas;
    use InteractsWithActions;

    public ?array $data = [];
    public $paymentMethods;
    public $monthly_plan;
    public $yearly_plan;
    public $plans;
    public $intent;
    public $radioDeckOptions;

    public function mount(): void
    {
        $this->form->fill();
        $this->paymentMethods = Auth::user()->paymentMethods()->map(fn($method) => collect($method->card)->put("id", collect($method)->get("id"))->all())->mapWithKeys(fn($method) => [collect($method)->get('id') => $method]);
        $this->monthly_plan = getDisplayAmount(env("STRIPE_MONTHLY_PLAN_PRICE_ID"));
        $this->yearly_plan = getDisplayAmount(env("STRIPE_YEARLY_PLAN_PRICE_ID"));

        $this->radioDeckOptions = [
            'monthly' =>  $this->monthly_plan . '/Monthly',
            'yearly' => env("STRIPE_CURRENCY_LOGO") . number_format((int) preg_replace('/\D/', '', $this->yearly_plan) / 12, 2) . '/Yearly'
        ];

        $this->plans = [
            'monthly' => $this->monthly_plan . " billed monthly",
            'yearly' =>  $this->yearly_plan . " " . " billed yearly",
        ];

        $this->intent = Auth::user()->createSetupIntent()->client_secret;
    }

    public function logoutAction(): Action
    {
        return Action::make('logout')
            ->outlined()
            ->label("Log Out")
            ->requiresConfirmation()
            ->action(function () {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                $this->redirect('/', navigate: true);
            });
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                RadioDeck::make('plan')
                    ->live()
                    ->options(fn() => $this->radioDeckOptions)
                    ->descriptions(fn() => $this->plans)
                    ->required()
                    ->iconPosition(IconPosition::Before) // Before | After
                    ->alignment(Alignment::Center) // Start | Center | End
                    ->colors('primary')
                    ->default("monthly")
                    ->extraOptionsAttributes([ // Extra attributes for option elements
                        'class' => 'text-xl'
                    ])
                    ->extraDescriptionsAttributes([ // Extra attributes for description elements
                        'class' => 'text-sm  py-2'
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function create($paymentMethod): void
    {
        $data = $this->form->getState();

        Auth::user()->newSubscription(
            $data["plan"],
            getPlanPriceId($data["plan"])
        )->create($paymentMethod);

        Notification::make()
            ->title('Subscribed successfully')
            ->success()
            ->send();

        $this->redirect(PostResource::getUrl('index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.subscribe');
    }
}
