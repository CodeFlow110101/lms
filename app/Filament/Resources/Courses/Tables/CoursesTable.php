<?php

namespace App\Filament\Resources\Courses\Tables;

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

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('image')->imageSize("100%")->imageWidth("100%")->grow(false)->extraAttributes(["class" => "flex justify-center items-center *:rounded-xl"]),
                    Stack::make([
                        TextColumn::make('name')->description(fn($record) => Str::limit($record->description, 500))->extraAttributes(["class" => "gap-4 py-4"])->size(TextSize::Large)->weight(FontWeight::Bold)->searchable(),
                    ])->grow(true)
                ])->extraAttributes(["class" => "flex items-start"])->from('md')
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
