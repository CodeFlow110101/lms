<?php

namespace App\Filament\Resources\Courses\Resources\Lessons\Pages;

use App\Filament\Resources\Courses\Resources\Lessons\LessonResource;
use App\Filament\Resources\Courses\Resources\Lessons\Widgets\ListLessonWidget;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewLesson extends ViewRecord
{
    protected static string $resource = LessonResource::class;

    public function getHeading(): string | Htmlable
    {
        return $this->record->name;
    }

    protected function getFooterWidgets(): array
    {
        return [
            ListLessonWidget::make(['lesson' => $this->record->id])
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
