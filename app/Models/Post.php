<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\Commentions\HasComments;
use Kirschbaum\Commentions\Contracts\Commentable;

class Post extends Model implements Commentable
{
    use HasComments;

    protected $table = "posts";

    protected $fillable = ["user_id", "title", "content"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class, "post_id", "id");
    }
}
