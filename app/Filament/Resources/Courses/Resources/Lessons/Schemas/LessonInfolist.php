<?php

namespace App\Filament\Resources\Courses\Resources\Lessons\Schemas;

use App\Filament\Infolists\Components\NavigationButtonEntry;
use App\Filament\Infolists\Components\ProgressBarEntry;
use App\Filament\Infolists\Components\VideoPlayerEntry;
use App\Filament\Resources\Courses\CourseResource;
use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;

class LessonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Grid::make()
                        ->schema([
                            ProgressBarEntry::make("course.ProgressPercentage")->hiddenLabel(),
                            RepeatableEntry::make('course.lessons')
                                ->hiddenLabel()
                                ->schema([
                                    NavigationButtonEntry::make('id')->hiddenLabel()->extraAttributes(["class" => "w-full"])
                                ])
                                ->extraAttributes(["class" => "gap-0"])
                                ->contained(false),
                        ])->columns(1)->grow(false),
                    Section::make([
                        TextEntry::make('description')->html()->hiddenLabel()->extraAttributes(["class" => "fi-prose"])->columnSpanFull(),
                        Section::make('Images')
                            ->collapsed()
                            ->hidden(fn($record) => $record->images->isEmpty())
                            ->schema([
                                RepeatableEntry::make('images')
                                    ->hiddenLabel()
                                    ->schema([
                                        ImageEntry::make("file")->extraImgAttributes(["class" => "w-full !h-auto"])
                                    ])->contained(false),
                            ]),
                        Section::make('Videos')
                            ->collapsed()
                            ->hidden(fn($record) => $record->videos->isEmpty())
                            ->schema([
                                RepeatableEntry::make('videos')
                                    ->hiddenLabel()
                                    ->schema([
                                        VideoPlayerEntry::make("file")->label(fn() => new HtmlString("<div></div>"))->columnSpanFull()->extraAttributes(["trackCompletion" => "true"]),
                                    ])->contained(false),
                            ])
                    ]),
                ])->from('sm')->extraAttributes(["class" => "sm:*:first:w-1/4"]),
            ])->columns(1);
    }
}
