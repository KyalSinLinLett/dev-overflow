<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notifications\followed_user;

class FollowsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store(User $owner, User $follower)
    {
    	if(!$owner->profile->followers->contains($follower))
    	{
    		$owner->notify(new followed_user($follower, $owner));
    	}

    	return auth()->user()->following()->toggle($owner->profile);
    }
}
