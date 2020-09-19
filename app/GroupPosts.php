<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Group;

class GroupPosts extends Model
{
	use Notifiable;

	protected $guarded = [];

	public function group()
	{
		return $this->belongsTo(Group::class);
	}

	// public function liked_by()

	// public function comments()

	// public function shared_by()
}
