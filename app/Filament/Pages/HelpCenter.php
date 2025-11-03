<?php

namespace App\Filament\Pages;

use App\Livewire\HelpCenterWidget;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class HelpCenter extends Page
{

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::check("is-member");
    }

    protected static ?string $navigationLabel = 'Chat with Admin';

    protected ?string $heading = "How can we help you?";

    protected static ?int $navigationSort = 3;

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    public static function canAccess(): bool
    {
        return Gate::check("is-member");
    }

    protected function getHeaderWidgets(): array
    {
        return [
            HelpCenterWidget::class
        ];
    }

    protected string $view = 'volt-livewire::filament.pages.help-center';
}
