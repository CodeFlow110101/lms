<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class Subscribe extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return !Auth::user()->current_plan;
    }

    public function getHeading(): string | Htmlable
    {
        return new HtmlString("<div></div>");
    }

    protected string $view = 'volt-livewire::filament.pages.subscribe';
}
