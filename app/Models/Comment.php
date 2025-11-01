<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\Commentions\Comment as CommentionsComment;

class Comment extends CommentionsComment
{

    public function getAuthorName(): string
    {
        return "{$this->author->first_name} {$this->author->last_name}";
    }
}
