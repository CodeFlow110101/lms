<?php

namespace App\Filament\Resources\Classrooms\Tables;

use App\Filament\Resources\Classrooms\ClassroomResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ClassroomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->imageSize("100%")->imageWidth("100%")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                Stack::make([
                    TextColumn::make('name')->description(fn($record) => Str::limit($record->description, 80))->extraAttributes(["class" => "gap-4 py-4"])->size(TextSize::Large)->weight(FontWeight::Bold)->searchable(),

                    // ProgressBarColumn::make('progress_percentage'),
                ])->grow(true),
            ])
            ->recordUrl(fn($record) => $record->lessons->first() ? ClassroomResource::getUrl('view', ['record' => $record->id, "lesson" => $record->lessons->first()->id]) : null)
            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
