<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = "courses";

    protected $fillable = ["sub_category_id", "name", "description", "image"];

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, "sub_category_id", "id");
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, "course_id", "id");
    }
}
