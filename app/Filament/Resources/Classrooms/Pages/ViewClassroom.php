<?php

namespace App\Filament\Resources\Classrooms\Pages;

use App\Filament\Resources\Classrooms\ClassroomResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ViewClassroom extends ViewRecord
{
    protected static string $resource = ClassroomResource::class;

    public function getHeading(): string | Htmlable
    {
        return $this->record->name;
    }
}
