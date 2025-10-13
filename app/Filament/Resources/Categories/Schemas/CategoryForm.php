<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                Section::make("Sub Categories")->schema([
                    Repeater::make('subCategories')->addActionLabel('Add Sub Categories')->label(fn() => new HtmlString("<div></div>"))->relationship()->simple(TextInput::make('name')->required()),
                ]),
            ])->columns(1);
    }
}
