<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Tables\Columns\CommentColumn;
use App\Filament\Tables\Columns\PostColumn;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make("title")->size(TextSize::Large)->description(fn($record) => "Posted by " . $record->user->name . " on " . $record->created_at->format('d M Y'))->extraAttributes(["class" => "*:last:italic"]),
                    PostColumn::make("content"),
                    ImageColumn::make('media.file')->extraImgAttributes(["class" => "w-full !h-auto"])->extraAttributes(["class" => "grid grid-cols-2"]),
                    CommentColumn::make('id')
                ])
            ])
            ->contentGrid([1])
            ->filters([
                //
            ])
            ->recordActions([
                // ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(fn(Builder $query) => $query->latest());
    }
}
