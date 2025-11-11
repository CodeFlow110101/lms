<?php

namespace App\Filament\Pages\Auth;

use App\Livewire\MembershipWidget;
use App\Livewire\PaymentMethodWidget;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Tapp\FilamentCountryCodeField\Forms\Components\CountryCodeSelect;

class EditProfile extends BaseEditProfile
{
    public static function isSimple(): bool
    {
        return false;
    }

    protected function getFooterWidgets(): array
    {
        return [
            MembershipWidget::class,
            PaymentMethodWidget::class
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar_url')
                    ->image()
                    ->directory('files')
                    ->columnSpanFull(),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
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
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])->columns(1);
    }
}
