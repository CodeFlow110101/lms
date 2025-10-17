<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lession extends Model
{
    protected $table = "lessons";

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'image',
        'video',
    ];
}
