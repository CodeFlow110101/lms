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
use Illuminate\Support\Str;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('image')->imageSize("100%")->imageWidth("300px")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                    Stack::make([
                        TextColumn::make('name')->description(fn($record) => Str::limit($record->description, 500))->extraAttributes(["class" => "gap-4 py-4"])->size(TextSize::Large)->weight(FontWeight::Bold)->searchable(),
                    ])->grow(true)
                ])->extraAttributes(["class" => "flex items-center"])->from('md')
            ])
            ->recordUrl(fn($record): string => LessonResource::getUrl('view', ['course' => $record->course->id, 'record' => $record->id,]))
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
