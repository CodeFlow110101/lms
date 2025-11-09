<?php

namespace App\Http\Middleware;

use App\Filament\Pages\Subscribe;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StripeUserRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Ensure the user has a Stripe customer
        if (! $user->stripe_id) {
            $user->createOrGetStripeCustomer();
        }

        if (Gate::check('is-administrator')) {
            return $next($request);
        }

        // If the user doesn't have a current plan, redirect them
        if (!request()->routeIs('filament.admin.pages.subscribe') && ! $user->current_plan) {
            return redirect(Subscribe::getUrl());
        }

        return $next($request);
    }
}
