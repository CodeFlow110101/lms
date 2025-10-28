<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $table = "lessons";

    protected $fillable = [
        'section_id',
        'name',
        'content',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, "section_id", "id");
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

    protected function casts(): array
    {
        return [
            'content' => 'collection',
        ];
    }
}
