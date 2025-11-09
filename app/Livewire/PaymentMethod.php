<?php

namespace App\Livewire;

use App\Filament\Pages\AddPaymentMethod;
use App\Filament\Pages\Auth\EditProfile;
use App\Models\User;
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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\Layout\Grid;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
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
            ->heading('Payment Methods')
            ->headerActions([
                Action::make('Create Payment Method')
                    ->modalContent(view('layout.add-payment-method'))->modalSubmitAction(false)
                    ->modalCancelAction(false)
            ])
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
                        $this->redirect(EditProfile::getUrl(), navigate: true);
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
}
