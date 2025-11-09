<?php

namespace App\Livewire;

use App\Filament\Pages\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Notifications\Notification;

class AddPaymentMethod extends Component
{

    public $intent;

    public function back()
    {
        Notification::make()
            ->title('Added successfully')
            ->success()
            ->send();

        $this->dispatch('close-modal', id: 'create-payment-method');
    }

    public function render()
    {
        return view('livewire.add-payment-method');
    }

    public function mount()
    {
        $this->intent = Auth::user()->createSetupIntent()->client_secret;
    }
}
