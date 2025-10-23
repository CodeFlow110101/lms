<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $table = "enrollments";

    protected $fillable = ["course_id", "user_id"];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, "course_id", "id");
    }
}
