<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
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
    		'profession' => 'required',
            'image' => '',
    	]);
    	
        if($request->image)
        {
            $imagePath = $request->image->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);

            $image->save();

            $imgArr = ['image' => $imagePath];
        }

        // dd($imgArr);

    	auth()->user()->profile->update(array_merge($data, $imgArr ?? []));

    	// return view('profile.index', compact('user'));
        return redirect(route('profile.show', $user));
    } 
}
