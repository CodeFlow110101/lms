<?php

namespace App\Filament\Resources\Classrooms\Pages;

use App\Filament\Resources\Classrooms\ClassroomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ListClassrooms extends ListRecords
{
    protected static string $resource = ClassroomResource::class;

    public function getHeading(): Htmlable
    {
        return new HtmlString("<div></div>");
    }
}
