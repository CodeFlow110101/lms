<?php

namespace App\Filament\Resources\Courses\Resources\Lessons\Schemas;

use App\Filament\Infolists\Components\VideoPlayerEntry;
use App\Filament\Resources\Courses\CourseResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\HtmlString;

class LessonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                VideoPlayerEntry::make("video")->label(fn() => new HtmlString("<div></div>"))->columnSpanFull(),
                TextEntry::make('description')->columnSpanFull(),
                TextEntry::make('course.name')->label("Course")->columnSpanFull()->url(fn($record) => CourseResource::getUrl('view', ['record' => $record->course->id]))->extraAttributes(['class' => 'hover:text-primary-400 hover:underline']),
            ]);
    }
}
