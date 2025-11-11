<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Str;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Tapp\FilamentCountryCodeField\Forms\Components\CountryCodeSelect;

class Register extends BaseRegister
{

    public $monthly_plan;
    public $yearly_plan;
    public $plans;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    TextInput::make('first_name')
                        ->required()
                        ->maxLength(255)
                        ->autofocus(),
                    TextInput::make('last_name')
                        ->required()
                        ->maxLength(255)
                        ->autofocus(),
                ]),
                CountryCodeSelect::make('phone_no_country_code')
                    ->label("Country Code")
                    ->live()
                    ->required(),
                TextInput::make('phone_no')
                    ->required()
                    ->mask('999999999')
                    ->prefix(fn(Get $get) => $get("phone_no_country_code"))
                    ->tel()
                    ->autofocus()
                    ->rule('digits:9'),
                $this->getEmailFormComponent(),
                Flex::make([
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                ]),
            ]);
    }

    protected function mutateFormDataBeforeRegister(array $data): array
    {
        return collect($data)->put("role_id", 2)->all();
    }

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->callHook('beforeFill');

        $this->form->fill();

        $this->callHook('afterFill');

        $this->monthly_plan = getDisplayAmount(env("STRIPE_MONTHLY_PLAN_PRICE_ID"));
        $this->yearly_plan = getDisplayAmount(env("STRIPE_YEARLY_PLAN_PRICE_ID"));

        $this->plans = [
            'monthly' => $this->monthly_plan . " (" . $this->monthly_plan . "/month)",
            'yearly' => $this->yearly_plan . " (" . number_format((int)$this->yearly_plan / 12, 2) . " " . Str::of($this->yearly_plan)->replaceMatches('/[^A-Za-z]/', '')->upper()->value() . "/month)",
        ];
    }
}
