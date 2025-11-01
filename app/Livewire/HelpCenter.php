<?php

namespace App\Livewire;

use App\Models\SupportTicket;
use App\Models\User;
use Livewire\Component;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;

class HelpCenter extends Component implements HasSchemas
{

    use InteractsWithSchemas;

    public function chat(Schema $schema): Schema
    {
        return $schema
            ->record(SupportTicket::firstOrCreate([
                'user_id' => Auth::id(),
            ]))
            ->components([
                CommentsEntry::make('comments')->mentionables(fn(Model $record) => User::all())->poll('10s')->hiddenLabel()->disableSidebar()->disablePagination(),
            ]);
    }

    public function render()
    {
        return view('livewire.help-center');
    }
}
