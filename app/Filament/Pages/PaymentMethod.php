<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Gate;

class PaymentMethod extends Page
{

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return Gate::check("is-member");
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Back')->url(Membership::getUrl())->outlined(),
            Action::make('Create Payment Method')->url(AddPaymentMethod::getUrl())
        ];
    }

    protected string $view = 'volt-livewire::filament.pages.payment-method';
}
