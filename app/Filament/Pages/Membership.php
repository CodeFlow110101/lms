<?php

namespace App\Filament\Pages;

use App\Livewire\MembershipWidget;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Membership extends Page
{

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Payment Methods')->url(PaymentMethod::getUrl()),
            Action::make("Subscribe to a Plan")->url(Subscribe::getUrl())->hidden((bool)Auth::user()->current_plan),
            Action::make("Cancel Subscribtion")
                ->color("danger")
                ->outlined()
                ->hidden(!Auth::user()->current_plan)
                ->requiresConfirmation()
                ->action(function () {
                    Auth::user()->subscriptions()->active()->first()->cancelNow();
                    $this->redirect(self::getUrl(), navigate: true);
                })
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MembershipWidget::class
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canAccess(): bool
    {
        return Gate::check("is-member");
    }

    protected string $view = 'volt-livewire::filament.pages.membership';
}
