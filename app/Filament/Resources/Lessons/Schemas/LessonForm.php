<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("name")->required(),
                Builder::make('content')
                    ->blocks([
                        Block::make('text')
                            ->schema([
                                RichEditor::make('text')->toolbarButtons([
                                    ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                    ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                    ['table'],
                                    ['undo', 'redo'],
                                ])->required()->columnSpanFull()
                            ])
                            ->columns(2),
                        Block::make('image')
                            ->schema([
                                FileUpload::make("image")->image()->required()->directory('files')->columnSpanFull()->required(),
                            ]),
                        Block::make('video')
                            ->schema([
                                FileUpload::make("video")->acceptedFileTypes([
                                    'video/mp4',
                                    'video/mpeg',
                                    'video/quicktime',
                                    'video/x-msvideo', // avi
                                    'video/x-matroska', // mkv
                                ])->required()->directory('files')->columnSpanFull(),
                            ]),
                    ])
            ])->columns(1);
    }
}
