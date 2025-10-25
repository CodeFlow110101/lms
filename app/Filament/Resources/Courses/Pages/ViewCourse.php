<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\Course;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Livewire;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;

    public function getHeading(): string | Htmlable
    {
        return "";
    }

    #[On('reset-view-course-page')]
    public function resetPage()
    {
        // ...
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
