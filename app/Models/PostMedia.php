<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    protected $table = "posts_media";

    protected $fillable = ["post_id", "file"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Post::class, "post_id", "id");
    }
}
