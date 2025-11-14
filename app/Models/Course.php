<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = ["name", "description", "image", "available_in_monthly_plan"];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, "course_id", "id");
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(
            Lesson::class,   // Final model
            Section::class,  // Intermediate model
            'course_id',     // Foreign key on sections table...
            'section_id',    // Foreign key on lessons table...
            'id',            // Local key on courses table...
            'id'             // Local key on sections table...
        );
    }

    public function getProgressAttribute()
    {
        return $this->lessons()->whereHas("progress", fn($query) => $query->where("user_id", Auth::id()))->count();
    }

    public function getLessonsReadAttribute()
    {
        return $this->lessons()
            ->whereHas(
                'progress',
                fn($query) =>
                $query->where('user_id', auth()->id())
            )
            ->count();
    }

    public function getIsFullyCompletedAttribute()
    {
        $userId = auth()->id();

        $total = $this->lessons()->count();
        if ($total === 0) {
            return false;
        }

        $completed = LessonProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $this->lessons->pluck('id'))
            ->where('is_completed', true)
            ->count();

        return $completed === $total;
    }

    public function getHasReadAllLessonsAttribute(): bool
    {
        $userId = auth()->id();

        $totalLessons = $this->lessons()->count();

        if ($totalLessons === 0) {
            return false;
        }

        $readLessons = LessonProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $this->lessons->pluck('id'))
            ->count();

        return $readLessons === $totalLessons;
    }

    public function getProgressPercentageAttribute()
    {
        $totalLessons = $this->lessons->count();
        $lessonsRead  = $this->lessons_read;

        if ($totalLessons === 0) {
            return 0;
        }

        // If user read all lessons → 50%
        if ($lessonsRead === $totalLessons) {
            // If also marked completed → 100%
            return $this->is_fully_completed ? 100 : 50;
        }

        // Otherwise proportional (reading progress)
        return round(($lessonsRead / $totalLessons) * 50, 2);
    }
}
