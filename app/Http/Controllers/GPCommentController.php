<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GPCommentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function store(Request $request, Post $post)
	{
		$data = $request->validate([
				'comment' => 'required|max:255',
				]);

		$post->comments()->create(array_merge($data, ['user_id' => auth()->user()->id]));

		return redirect(route('post.show', $post));
	}

}
