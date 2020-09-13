<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

   	// public function index()
   	// {
   	// 	// $users = auth()->user()->following()->pluck('profiles.user_id');
   	// 	// $posts = Post::whereIn('user_id', $users)->with('user')->latest();

   	// 	// return redirect(route('post.index', $posts));
   	// }

   	public function store(Request $request)
   	{
   		$data = $request->validate([
   			'title' => 'required',
   			'content' => 'required',
   			'postimage' => '',
   		]);

   		if ($request->postimage)
   		{
   			$imagePath = $request->postimage->store('post', 'public');

   			$image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);

   			$image->save();

   			$imgArr = ['postimage' => $imagePath];
   		}

   		auth()->user()->posts()->create(array_merge($data, $imgArr ?? []));

      $user = auth()->user();

   		return redirect(route('profile.show', $user));
   	}

   	public function show(Post $post)
   	{
      $likes = (auth()->user()) ? auth()->user()->liked_posts->contains($post->id) : false;

   		return view('post.show', compact('post', 'likes'));
   	}

    public function feed(){
      $posts = Post::latest()->get();
      return view('welcome', compact('posts'));
    }

    public function edit(Post $post)
    {
      return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    { 
      $data = $request->validate([
        'title' => 'required',
        'content' => 'required',
        'postimage' => '',
      ]);

      if ($request->postimage)
      {
        $imagePath = $request->postimage->store('post', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);

        $image->save();

        $imgArr = ['postimage' => $imagePath];
      }

      Post::find($post->id)->update(array_merge($data, $imgArr ?? []));

      return redirect(route('post.show', $post));
    }

    public function delete(Post $post)
    {
      $post->delete();
      $user = $post->user;
      // return view('profile.index', compact('user'));
      return redirect(route('profile.show', $user));
    }

    public function sharePost(Request $request, Post $post)
    {
      auth()->user()->shared_posts()->attach($post);

      return redirect()->back()->with(['message'=>"Post is added to your shared posts collection."]);
    }

    public function shareRemove(Post $post)
    {
      // removes the shared post
      auth()->user()->shared_posts()->detach($post);

      $user = auth()->user();

      return redirect(route('profile.sharedPosts', $user));

    }

    public function privateFeed()
    {
      $users = auth()->user()->following()->pluck('profiles.user_id');

      $posts = Post::whereIn('user_id', $users)->latest()->get();

      return view('post.mycircle', compact('posts'));
    }

}
