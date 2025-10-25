<?php

namespace App\Filament\Resources\Courses\Resources\Lessons\Tables;

use App\Filament\Resources\Courses\Resources\Lessons\LessonResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('name')->size(TextSize::Large)->weight(FontWeight::Bold),
                ])
            ])
            ->recordUrl(fn($record): string => LessonResource::getUrl('view', ['course' => $record->course->id, 'record' => $record->id,]))
            ->filters([
                //
            ])
            ->paginated(false)
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
