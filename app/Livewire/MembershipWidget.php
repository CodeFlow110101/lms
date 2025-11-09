<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Stripe\Price;
use Stripe\Stripe;

class MembershipWidget extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    public $amount;
    public $currency;
    public $plan;

    public static function canView(): bool
    {
        return Gate::check("is-member");
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Current Subscription Plan', Str::headline($this->plan))
                ->description($this->amount . ' ' . $this->currency)
                ->color('success'),
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        Stripe::setApiKey(config('cashier.secret'));

        $subscription = $user->subscriptions()->active()->first();

        if ($subscription && $subscription->active()) {
            $price = Price::retrieve($subscription->stripe_price);
            $this->amount = $price->unit_amount / 100;
            $this->currency = strtoupper($price->currency);
            $this->plan = $user->current_plan;
        } else {
            $this->plan = "Not Subscribed";
        }
    }
}
