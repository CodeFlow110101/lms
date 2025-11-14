<?php

namespace App\Filament\Infolists\Components;

use App\Filament\Resources\Classrooms\ClassroomResource;
use App\Models\Lesson;
use Filament\Infolists\Components\Entry;

class NavigationButtonEntry extends Entry
{
    protected string $view = 'filament.infolists.components.navigation-button-entry';

    public function getViewData(): array
    {
        $lesson = Lesson::find($this->getState());
        return [
            'id' => $this->getState(),
            'record' => $this->getRecord(),
            'url' => ClassroomResource::getUrl("view", ["record" => $this->getRecord()->section->course->id, "lesson" => $lesson->id]),
        ];
    }
}
