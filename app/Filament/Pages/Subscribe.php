<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Subscribe extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return !Auth::user()->current_plan;
    }

    protected string $view = 'volt-livewire::filament.pages.subscribe';
}
