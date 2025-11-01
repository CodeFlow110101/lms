<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class HelpCenterWidget extends Widget
{
    protected static bool $isLazy = false;

    protected string $view = 'volt-livewire::livewire.help-center-widget';
}
