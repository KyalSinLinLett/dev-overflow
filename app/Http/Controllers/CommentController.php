<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;
use App\GroupPosts;
use App\Group;
use App\GPComment;
use App\Notifications\commented;
use App\Notifications\group_post_commented;

class CommentController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    ////// NORMAL POSTS ////////

    public function store(Request $request, Post $post, User $user)
    {
  		$data = $request->validate([
  			'comment' => 'required|max:255',
  		]);

  		$post->comments()->create(array_merge($data, ['user_id' => auth()->user()->id]));

        $post_owner = User::find($post->user_id);
        $commentor = auth()->user();

        if($post_owner != $commentor){
            $post_owner->notify(new commented($commentor, $post, $post_owner));
        }

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

    ////// NORMAL POSTS ////////

    ////// GROUP POSTS /////////
    
    public function gp_comment_store(Request $request, GroupPosts $gp, User $user)
    {   
        $data = $request->validate([
            'comment' => 'required|max:255',
        ]);

        $gp_comment_data = array_merge($data, ['group_posts_id' => $gp->id, 'user_id' => Auth::id()]);

        try {

            $gp->gp_comments()->create($gp_comment_data);

            $commentor = auth()->user();
            $gp_owner = User::find($gp->user_id);
            $group = Group::find($gp->group_id);

            if($commentor != $gp_owner)
            {
                User::find($gp->user_id)->notify(new group_post_commented($commentor, $gp, $gp_owner, $group));
            }

            return redirect()->back()->with('success', 'Comment is posted.');

        } catch (Exception $e) {

            return redirect()->back()->with('error', $e);      

        }
    }

    public function gp_comment_edit(GPComment $gp_cmt)
    {
        return view('group.gp-comment-edit', compact('gp_cmt'));
    }

    public function gp_comment_update(Request $request)
    {
        try {
            
            GPComment::findOrFail($request->gp_cmt_id)->update(['comment' => $request->comment]);

            return redirect(route('group.view-post', GroupPosts::find($request->gp_id)))->with('success', 'Comment is successfully edited.');

        } catch (Exception $e) {
            
            return redirect()->back()->with('error', $e);

        }
    }
    
    public function gp_comment_delete(GPComment $gp_cmt)
    {
        try {
            
            GPComment::findOrFail($gp_cmt->id)->delete();

            return redirect()->back()->with('success', 'Comment is deleted.');

        } catch (Exception $e) {
            
            return redirect()->back()->with('error', $e);

        }
    }

    /////// GROUP POSTS /////////



}
