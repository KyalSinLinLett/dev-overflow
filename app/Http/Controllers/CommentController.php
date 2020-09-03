<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;

class CommentController extends Controller
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

    public function delete(Comment $comment)
    {
      $comment->delete();
      $post = $comment->post;
      return redirect(route('post.show', $post));
    }

    public function edit(Comment $comment)
    {
    	return view('comment.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
   		$data = $request->validate([
   			'comment' => 'required|max:255',
   		]);

      $comment->where('id', $comment->id)->update($data);
   		
      $post = $comment->post;

      return redirect(route('post.show', $post));
    }
}
