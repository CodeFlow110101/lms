<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class Membership extends Page
{

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
