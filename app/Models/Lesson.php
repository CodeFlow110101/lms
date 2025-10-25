<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $table = "lessons";

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'image',
        'video',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, "course_id", "id");
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class, "lesson_id", "id");
    }

    public function getCourseLessonsAttribute()
    {
        return $this->course->lessons;
    }

    public function images(): HasMany
    {
        return $this->hasMany(LessonImage::class, "lesson_id", "id");
    }

    public function videos(): HasMany
    {
        return $this->hasMany(LessonVideo::class, "lesson_id", "id");
    }
}
