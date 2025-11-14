<?php

namespace App\Filament\Resources\Classrooms\Pages;

use App\Filament\Resources\Classrooms\ClassroomResource;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\HtmlString;
use Filament\Actions\Action;

class ViewClassroom extends ViewRecord
{
    protected static string $resource = ClassroomResource::class;

    public $lesson;

    protected function authorizeAccess(): void
    {
        if (!auth()->user()->can('access', $this->record)) {
            abort(403);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('mark_course_as_completed')
                ->outlined()
                ->requiresConfirmation()
                ->action(fn() => LessonProgress::whereIn('lesson_id', $this->record->lessons->pluck('id'))
                    ->where('user_id', auth()->id())
                    ->update([
                        'is_completed' => true
                    ]))
                ->visible(fn() => Gate::check("is-member") && $this->record->has_read_all_lessons && ! $this->record->is_fully_completed),
        ];
    }

    public function getHeading(): string | Htmlable
    {
        return $this->record->name;
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->lesson = Lesson::find(request()->route('lesson'));
    }

    public function markCompleted()
    {
        if (Gate::check("is-member")) {
            LessonProgress::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'lesson_id' => $this->lesson->id,
                ],
            );
        }
    }
}
