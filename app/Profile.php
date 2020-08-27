<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
