<?php

namespace App\Livewire;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\HelpCenter;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Gate;

class NavbarButtons extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function settings(): Action
    {
        return Action::make('settings')
            ->outlined()
            ->size("sm")
            ->url(EditProfile::getUrl());
    }

    public function chatWIthAdmin(): Action
    {
        return Action::make('Chat With Admin')
            ->outlined()
            ->size("sm")
            ->hidden(Gate::check('is-administrator'))
            ->url(HelpCenter::getUrl());
    }

    public function render()
    {
        return view('livewire.navbar-buttons');
    }
}
