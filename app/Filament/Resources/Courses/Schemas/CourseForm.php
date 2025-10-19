<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Category;
use App\Models\SubCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sub_category_id')
                    ->label('Sub Category')
                    ->options(fn($get) => SubCategory::with("category")->get()->mapWithKeys(fn($subcategory) => [$subcategory->id => $subcategory->name . " (" . $subcategory->category->name . ")"]))
                    ->searchable()
                    ->native(false)
                    ->required()
                    ->placeholder("Select a Category"),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->directory('files')
                    ->columnSpanFull(),
                Repeater::make("lessons")
                    ->relationship()
                    ->defaultItems(1)
                    ->schema([
                        TextInput::make("name")->required(),
                        Textarea::make("description"),
                        FileUpload::make("image")->image()->required()->directory('files')
                            ->columnSpanFull(),
                        FileUpload::make("video")->required()->directory('files')->acceptedFileTypes(['video/*'])
                            ->maxSize(102400)
                            ->columnSpanFull()

                    ])
            ])->columns(1);
    }
}
