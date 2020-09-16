<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Profile;
use App\Post;

class Group extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function groupImage()
    {
        $imagePath = ($this->groupPhoto) ? $this->groupPhoto : 'group/PF9Gqf3I50YXUGQ7fSs4XWz4QrXXk89SAFFMjspi.png';

        return '/storage/' . $imagePath;
    }

    public function admin()
    {
    	return $this->belongsToMany(Profile::class, 'admin_group', 'group_id', 'profile_id');
    }

    public function member()
    {
    	return $this->belongsToMany(Profile::class, 'member_group', 'group_id', 'profile_id');
    }

    public function posts()
    {
    	return $this->hasMany(Post::class);
    }
}
