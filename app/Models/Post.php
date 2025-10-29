<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
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

    public function getCommentCountAttribute()
    {
        return $this->comments->count();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class, "post_id", "id");
    }

    public function getIsLikedAttribute()
    {
        return $this->likes()->where("user_id", Auth::id())->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
}
