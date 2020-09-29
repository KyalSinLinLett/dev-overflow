<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Notifications\shared_post;

class PostController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    // public function index()
    // {
    //  // $users = auth()->user()->following()->pluck('profiles.user_id');
    //  // $posts = Post::whereIn('user_id', $users)->with('user')->latest();

    //  // return redirect(route('post.index', $posts));
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

        $image = Image::make("storage/{$imagePath}")->fit(1200, 1200);

        $image->save();

        $imgArr = ['postimage' => $imagePath];
      }

      auth()->user()->posts()->create(array_merge($data, $imgArr ?? []));

      $user = auth()->user();

      return redirect(route('profile.show', $user));
    }

    public function show(Post $post)
    {
      $type = "post";

      $likes = (auth()->user()) ? auth()->user()->liked_posts->contains($post->id) : false;

      return view('post.show', compact('post', 'likes', 'type'));
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

        $image = Image::make("storage/{$imagePath}")->fit(1200, 1200);

        $image->save();

        $imgArr = ['postimage' => $imagePath];
        
        Storage::delete($post->image);
      }

      Post::find($post->id)->update(array_merge($data, $imgArr ?? []));

      return redirect(route('post.show', $post));
    }

    public function delete(Post $post)
    {
      Storage::delete($post->image);
      $post->delete();
      $user = $post->user;
      // return view('profile.index', compact('user'));
      return redirect(route('profile.show', $user));
    }

    public function sharePost(Request $request, Post $post, User $user)
    {
      auth()->user()->shared_posts()->attach($post);

      $post_owner = User::find($post->user_id);
      $sharer = auth()->user();

      if($post_owner != $sharer)
      {
        $post_owner->notify(new shared_post($post, $post_owner, $sharer));
      }

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
