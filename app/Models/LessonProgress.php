<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    protected $table = "lesson_progress";

    protected $fillable = ["lesson_id", "user_id", "is_completed"];
}
