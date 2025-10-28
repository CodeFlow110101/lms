<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Category;
use App\Models\SubCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->directory('files')
                    ->columnSpanFull(),
                // Section::make("Lessons")
                //     ->schema([
                //         Repeater::make("lessons")
                //             ->label(fn() => new HtmlString("<div></div>"))
                //             ->addActionLabel('Add Lesson')
                //             ->relationship()
                //             ->defaultItems(1)
                //             ->collapsed()
                //             ->schema([
                //                 TextInput::make("name")->required(),
                //                 RichEditor::make('description')->toolbarButtons([
                //                     ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                //                     ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                //                     ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                //                     ['table'],
                //                     ['undo', 'redo'],
                //                 ]),
                //                 Repeater::make("images")
                //                     ->relationship()
                //                     ->schema([
                //                         FileUpload::make("file")->image()->required()->directory('files')->columnSpanFull(),
                //                     ])->grid(2),
                //                 Repeater::make("videos")
                //                     ->relationship()
                //                     ->schema([
                //                         FileUpload::make("file")->acceptedFileTypes([
                //                             'video/mp4',
                //                             'video/mpeg',
                //                             'video/quicktime',
                //                             'video/x-msvideo', // avi
                //                             'video/x-matroska', // mkv
                //                         ])->required()->directory('files')->columnSpanFull(),
                //                     ])->grid(2),
                //             ])
                //     ]),
            ])->columns(1);
    }
}
