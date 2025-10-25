<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\User;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\Commentions\Filament\Infolists\Components\CommentsEntry;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('content')->html()->extraAttributes(["class" => "fi-prose"]),
                ImageEntry::make('media.file')->hiddenLabel()->extraImgAttributes(["class" => "w-full !h-auto"])->extraAttributes(["class" => "grid grid-cols-2"]),
                TextEntry::make('comment_count')->getStateUsing(fn($record) => $record->comment_count . " Comments")->hiddenLabel()->badge()->icon(Heroicon::ChatBubbleLeft)->size(TextSize::Medium),
                Section::make('')
                    ->schema([
                        CommentsEntry::make('comments')->extraEntryWrapperAttributes(["class" => "comments-wrapper"])->mentionables(fn(Model $record) => User::all())->poll('10s')->hiddenLabel()->disableSidebar()->disablePagination(),
                    ])
            ])->columns(1);
    }
}
