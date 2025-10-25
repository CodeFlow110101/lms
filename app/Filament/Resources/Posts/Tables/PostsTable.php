<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Filament\Tables\Columns\CommentColumn;
use App\Filament\Tables\Columns\PostColumn;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Count;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Split::make([
                        ImageColumn::make('user.avatar')->defaultImageUrl(fn($state) => $state)->circular()->grow(false),
                        TextColumn::make("user.name")->size(TextSize::Large)->weight(FontWeight::Bold),
                    ]),
                    TextColumn::make("title")->size(TextSize::Large)->description(fn($record) => $record->created_at->format('d M Y'))->extraAttributes(["class" => "*:last:italic"]),
                    TextColumn::make("content")->html()->extraAttributes(["class" => "fi-prose max-h-10"]),
                    ImageColumn::make('media.file')->extraImgAttributes(["class" => "w-full !h-auto"])->extraAttributes(["class" => "grid grid-cols-2"]),
                    TextColumn::make("comment_count")->icon(Heroicon::ChatBubbleLeft)->badge()->size(TextSize::Medium)
                ])->extraAttributes(["class" => "gap-10"])
            ])
            ->contentGrid([1])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->modalHeading(fn($record) => $record->user->name . " | " . $record->title)->stickyModalHeader()->stickyModalFooter()->label('')->icon(null),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(fn(Builder $query) => $query->latest());
    }
}
