<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;

class Post extends Model
{
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function liked_by()
    {
    	return $this->belongsToMany(User::class);
    }

    public function comments()
    {
    	return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    public function shared_by()
    {
        return $this->belongsToMany(User::class, 'post_user_share');
    }
}
