<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Group;

class Profile extends Model
{
	protected $guarded = [];

	public function profileImage()
	{
		$imagePath = ($this->image) ? $this->image : 'profile/q4Iwzmvho8JlQvHnWLBhrEWD2HjhZ7PlZk4W1PXF.png';

		return '/storage/' . $imagePath;
	}

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function followers()
    {
    	return $this->belongsToMany(User::class);
    }

    public function groups() // returns groups where the profile user is admin, sorry for the poor naming 
    {
        return $this->belongsToMany(Group::class, 'admin_group', 'profile_id', 'group_id');
    }

    public function member_of_groups()
    {
        return $this->belongsToMany(Group::class, 'member_group', 'profile_id', 'group_id');
    }

}
