<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
