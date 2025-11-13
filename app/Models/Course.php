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

    public function getProgressPercentageAttribute()
    {
        $completed = (int) $this->progress;
        $total = (int) $this->lessons->count();

        if ($total === 0) {
            return 0;
        }

        return round(($completed / $total) * 100, 2);
    }
}
