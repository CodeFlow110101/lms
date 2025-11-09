<?php

namespace App\Livewire;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Gate;

class PaymentMethodWidget extends Widget
{
    protected int | string | array $columnSpan = "full";

    public static function canView(): bool
    {
        return Gate::check("is-member");
    }

    protected string $view = 'volt-livewire::livewire.payment-method-widget';
}
