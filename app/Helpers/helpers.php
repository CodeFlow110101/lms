<?php

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
