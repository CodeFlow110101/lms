<?php

namespace App\Livewire;

use App\Filament\Resources\Courses\CourseResource;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class Learings extends StatsOverviewWidget
{

    protected function getHeading(): ?string
    {
        return 'My Learnings';
    }

    protected function getDescription(): ?string
    {
        return "Courses you have enrolled";
    }

    public function redirectToResource($path)
    {
        $this->redirect($path, navigate: true);
    }

    protected function getStats(): array
    {
        return Auth::user()->enrollments()->with("course")->get()->map(function ($enrollment) {
            return Stat::make($enrollment->course->name, $enrollment->course->progress . " / " . $enrollment->course->lessons->count() . " Completed")
                ->description(fn() => $enrollment->course->progressPercentage . "% Completed")
                ->descriptionColor("success")
                ->extraAttributes([
                    'class' => 'navigation-widget',
                    'wire:click' => "redirectToResource('" . CourseResource::getUrl("view", ["record" => $enrollment->course->id]) . "')",
                ]);
        })->all();
    }
}
