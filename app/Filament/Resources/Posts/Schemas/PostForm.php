<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("title")->required(),
                RichEditor::make('content')->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                    ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                    ['table'],
                    ['undo', 'redo'],
                ]),
                Repeater::make('media')
                    ->label("Images (Max 4)")
                    ->relationship()
                    ->defaultItems(0)
                    ->maxItems(4)
                    ->schema([
                        FileUpload::make('file')->label(fn() => new HtmlString("<div></div>"))->required()
                    ]),
            ])->columns(1);
    }
}
