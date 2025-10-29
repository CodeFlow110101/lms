<?php

namespace App\Filament\Pages;

use App\Livewire\Learings;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return false;
    }

    public static function getNavigationIcon(): ?string
    {
        return null;
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}
