<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
