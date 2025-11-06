<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class Membership extends Page
{

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Payment Methods')->url(PaymentMethod::getUrl())
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return Gate::check("is-member");
    }

    protected string $view = 'volt-livewire::filament.pages.membership';
}
