<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\GroupPosts;
use App\Group;
use App\Notifications\post_liked;
use App\Notifications\group_post_liked;

class LikeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store($pid, $type, $uid)
    {

    	$response = [];

        switch ($type) {
            case 'post':
                $post = Post::find($pid);
                $response = [
                    "toggle" => auth()->user()->liked_posts()->toggle($post), 
                    "like_count" => $post->liked_by->count()
                ]; 

                if(auth()->user()->liked_posts->contains($post)) { // if user has just liked it, itll be true, if user disliked then its false
                    $post_owner = User::find($post->user_id);
                    if ($post_owner->id != auth()->user()->id)
                    {
                        $post_owner->notify(new post_liked($post_owner, auth()->user(), $post));                        
                    }
                }

                break;

            case 'gp':
                $gp = GroupPosts::find($pid);
                $response = [
                    "toggle" => auth()->user()->liked_group_posts()->toggle($gp), 
                    "like_count" => $gp->liked_by->count()
                ]; 

                if(auth()->user()->liked_group_posts->contains($gp)) { //can get owner of gp by $gp->user_id
                    $gp_owner = User::find($gp->user_id);
                    if ($gp_owner->id != auth()->user()->id)
                    {
                        $gp_owner->notify(new group_post_liked($gp_owner, auth()->user(), $gp, Group::find($gp->group_id)));
                    }
                }

                break;
        }

    	return $response;
    }

}
