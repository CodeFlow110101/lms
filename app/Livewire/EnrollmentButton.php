<?php

namespace App\Livewire;

use App\Filament\Resources\Courses\CourseResource;
use App\Models\Course;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EnrollmentButton extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public $course;

    public function enroll(): Action
    {
        return Action::make('enroll')
            ->label('Enroll Now')
            ->requiresConfirmation()
            ->action(function () {
                Auth::user()->enrollments()->create(["course_id" => $this->course->id]);

                Notification::make()
                    ->title('Enrolled Successfully')
                    ->success()
                    ->send();

                $this->dispatch('reset-view-course-page');
            })
            ->size("xl")
            ->extraAttributes(["class" => "w-full"]);
    }

    public function mount($id)
    {
        $this->course = Course::find($id);
    }

    public function render()
    {
        return view('livewire.enrollment-button');
    }
}
