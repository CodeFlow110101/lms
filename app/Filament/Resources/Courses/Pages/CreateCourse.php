<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    public function getHeading(): Htmlable
    {
        return new HtmlString("<div></div>");
    }
}
