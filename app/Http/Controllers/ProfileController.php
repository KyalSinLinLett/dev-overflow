<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Notifications\post_liked;
use Illuminate\Support\Facades\DB;
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

        return redirect(route('profile.show', $user));
    } 

    public function viewLikedPosts(User $user)
    {
        if ($user->id != auth()->user()->id)
        {
            return response()->json(['error' => 'Not authorized.'],403);
        }

        $posts = auth()->user()->liked_posts;
        return view('post.likedPosts', compact('posts'));
    }

    public function sharedPosts(User $user)
    {
        $shared_posts = $user->shared_posts()->latest()->get();
        
        return view('post.sharedPosts', compact('shared_posts', 'user'));
    }

    public function followerList(User $user)
    {
        $followers = $user->profile->followers;
        return view('profile.followerList', compact('followers'));
    }

    public function followingList(User $user)
    {
        $following = $user->following;
        return view('profile.followingList', compact('following'));
    }

    public function notifications()
    {
        $post_likes = Auth::user()->notifications()->where('type', "App\Notifications\post_liked")->get();

        $group_post_likes = Auth::user()->notifications()->where('type', "App\Notifications\group_post_liked")->get();
        
        $follows = Auth::user()->notifications()->where('type', "App\Notifications\followed_user")->get();

        $notifications = $post_likes->merge($group_post_likes)->merge($follows)->sortByDesc('created_at');

        dd($notifications);

        return view('profile.notifications', compact('notifications'));
        
    }
}
