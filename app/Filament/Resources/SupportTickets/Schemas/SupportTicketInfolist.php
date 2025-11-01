<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;

class SupportTicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make("user.full_name"),
                TextEntry::make("user.email"),
                CommentsEntry::make('comments')->columnSpanFull()->mentionables(fn(Model $record) => User::all())->poll('10s')->hiddenLabel()->disableSidebar()->disablePagination(),
            ]);
    }
}
