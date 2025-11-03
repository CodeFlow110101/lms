<?php

namespace App\Livewire;

use App\Filament\Pages\Membership;
use Livewire\Component;

class MembershipStatusButton extends Component
{

    public $url;

    public function mount()
    {
        $this->url = Membership::getUrl();
    }

    public function render()
    {
        return view('livewire.membership-status-button');
    }
}
