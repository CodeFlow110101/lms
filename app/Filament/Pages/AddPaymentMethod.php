<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class AddPaymentMethod extends Page
{

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return Gate::check("is-member");
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Back')->url(PaymentMethod::getUrl())->outlined()
        ];
    }

    protected string $view = 'volt-livewire::filament.pages.add-payment-method';
}
