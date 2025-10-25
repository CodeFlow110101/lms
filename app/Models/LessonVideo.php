<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonVideo extends Model
{
    protected $table = "lesson_videos";

    protected $fillable = ["lesson_id", "file"];
}
