<?php

use Stripe\Stripe;
use Stripe\Price;

if (! function_exists('getPlanPriceId')) {
    function getPlanPriceId($plan)
    {
        if ($plan == "monthly") {
            return env("STRIPE_MONTHLY_PLAN_PRICE_ID");
        } elseif ($plan == "yearly") {
            return env("STRIPE_YEARLY_PLAN_PRICE_ID");
        }
    }
}

if (! function_exists('getDisplayAmount')) {
    function getDisplayAmount(string $priceId): string
    {
        Stripe::setApiKey(config('cashier.secret'));

        $price = Price::retrieve($priceId);

        // Convert amount from cents to real value
        $amount = $price->unit_amount / 100;

        // Currency in uppercase (e.g., "INR", "USD")
        return env("STRIPE_CURRENCY_LOGO") . $amount;
    }
}
