<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonImage extends Model
{
    protected $table = "lesson_images";

    protected $fillable = ["lesson_id", "file"];
}
