<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = ["name", "description", "image"];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, "course_id", "id");
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, "course_id", "id");
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
