<?php

namespace App\Livewire;

use App\Filament\Pages\PaymentMethod as PagesPaymentMethod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class PaymentMethod extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->records(fn() => Auth::user()->paymentMethods()->map(fn($method) => collect($method->card)->put("id", collect($method)->get("id"))->all())->all())
            ->columns([
                TextColumn::make('brand')->label("Card")->formatStateUsing(fn($state) => Str::headline($state)),
                TextColumn::make('last4')->label("Card Number")->formatStateUsing(fn($state) => "**** **** **** " . $state),
            ])
            ->filters([
                // ...
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        Auth::user()->deletePaymentMethod($record['id']);
                        Notification::make()
                            ->title('Deleted successfully')
                            ->success()
                            ->send();
                        $this->redirect(PagesPaymentMethod::getUrl(), navigate: true);
                    })
                    ->icon(Heroicon::Trash)
            ])
            ->toolbarActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.payment-method');
    }

    public function mount()
    {
        Auth::user()->createOrGetStripeCustomer();
    }
}
