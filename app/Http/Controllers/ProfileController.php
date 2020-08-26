<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

    	return view('profile.index', compact('user', 'follows'));
    }

    public function edit(User $user)
    {
    	$this->authorize('update', $user->profile);
    	return view('profile.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
	 	$data = $request->validate([
    		'biography' => 'required',
    		'profession' => 'required'
    	]);
    	
    	auth()->user()->profile->update($data);

    	return view('profile.index', compact('user'));
    } 
}
