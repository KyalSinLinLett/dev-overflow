<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Group;
use App\User;

class GroupPosts extends Model
{
	use Notifiable;

	protected $guarded = [];

	public function group()
	{
		return $this->belongsTo(Group::class);
	}

	public function liked_by()
	{
		return $this->belongsToMany(User::class);
	}

	public function gp_comments()
	{
		return $this->hasMany(GPComment::class)->orderBy('created_at', 'DESC');
	}

}
