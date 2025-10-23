<?php

namespace App\Filament\Pages;

use App\Livewire\Learings;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return collect(Filament::getWidgets())->push(Learings::class)->all();
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}
