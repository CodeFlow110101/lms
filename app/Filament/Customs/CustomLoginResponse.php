<?php

namespace App\Filament\Customs;

use App\Filament\Resources\Posts\PostResource;
use Filament\Auth\Http\Responses\LoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends LoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        return redirect()->intended(PostResource::getUrl("index"));
    }
}
