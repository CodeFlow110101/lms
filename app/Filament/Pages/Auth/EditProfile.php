<?php

namespace App\Filament\Pages\Auth;

use App\Livewire\MembershipWidget;
use App\Livewire\PaymentMethodWidget;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Schema;

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
                TextInput::make('phone_no')
                    ->required()
                    ->mask('999999999')
                    ->prefix('+33')
                    ->tel()
                    ->autofocus()
                    ->rule('digits:9'),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])->columns(1);
    }
}
