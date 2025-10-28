<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    public function getHeading(): Htmlable
    {
        return new HtmlString("<div></div>");
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label("New Course"),
        ];
    }
}
