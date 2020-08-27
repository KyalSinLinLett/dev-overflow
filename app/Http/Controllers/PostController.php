<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

   	public function index()
   	{
   		$users = auth()->user()->following()->pluck('profiles.user_id');
   		$posts = Post::whereIn('user_id', $users)->with('user')->latest();

   		return redirect(route('post.index', $posts));
   	}

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

   			$image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);

   			$image->save();

   			$imgArr = ['postimage' => $imagePath];
   		}

   		auth()->user()->posts()->create(array_merge($data, $imgArr ?? []));

      $user = auth()->user();

   		return redirect(route('profile.show', $user));
   	}

   	public function show(Post $post)
   	{
   		return view('post.show', compact('post'));
   	}
}
