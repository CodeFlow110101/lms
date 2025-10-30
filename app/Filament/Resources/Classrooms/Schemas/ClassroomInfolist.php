<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use App\Filament\Infolists\Components\NavigationButtonEntry;
use App\Filament\Infolists\Components\ProgressBarEntry;
use App\Filament\Infolists\Components\VideoPlayerEntry;
use App\Models\Lesson;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\HtmlString;

class ClassroomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->record(Lesson::find(request()->route('lesson')))
            ->components([
                Flex::make([
                    Grid::make()
                        ->schema([
                            // ProgressBarEntry::make("course.ProgressPercentage")->hiddenLabel(),
                            RepeatableEntry::make('section.course.sections')
                                ->hiddenLabel()
                                ->schema([
                                    Section::make(fn($record) => $record->name)
                                        ->collapsible()
                                        ->collapsed(fn($record) => !$record->lessons->pluck("id")->contains(request()->route('lesson')))
                                        ->schema([
                                            RepeatableEntry::make('lessons')
                                                ->hiddenLabel()
                                                ->schema([
                                                    NavigationButtonEntry::make('id')->hiddenLabel()->extraAttributes(["class" => "w-full"])
                                                ])->contained(false)->extraAttributes(["class" => "gap-0"]),
                                        ])->contained(false)
                                ])
                                ->contained(false)
                                ->columns(1),
                        ])->columns(1)->grow(false),
                    Section::make()->extraAttributes(["class" => "w-false"])
                        ->schema([
                            TextEntry::make("name")->hiddenLabel()->size(TextSize::Large),
                            Section::make()
                                ->schema(
                                    fn($record) => $record->content
                                        ->map(function ($rows) {
                                            if ($rows['type'] == "text") {
                                                return TextEntry::make('description')->hiddenLabel()->default($rows['data']["text"])->html()->extraAttributes(["class" => "fi-prose py-3"]);
                                            } else if ($rows['type'] == "image") {
                                                return ImageEntry::make('image')->hiddenLabel()->default($rows['data']["image"])->extraAttributes(["class" => "py-3"]);
                                            } else if ($rows['type'] == "video") {
                                                return VideoPlayerEntry::make('image')->hiddenLabel()->default($rows['data']["video"])->extraAttributes(["class" => "py-3"]);
                                            }
                                        })
                                        ->all()
                                )
                        ]),
                ])->from('sm')->extraAttributes(["class" => "sm:*:first:w-1/4"]),
            ])->columns(1);
    }
}
