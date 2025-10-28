<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $table = "sections";

    protected $fillable = ["name", "course_id"];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, "section_id", "id");
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, "course_id", "id");
    }
}
