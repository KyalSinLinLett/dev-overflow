<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\GroupPosts;

class LikeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store($id, $type)
    {
    	$response = [];

        switch ($type) {
            case 'post':
                $post = Post::find($id);
                $response = [
                    "toggle" => auth()->user()->liked_posts()->toggle($post), 
                    "like_count" => $post->liked_by->count()
                ]; 
                break;

            case 'gp':
                $gp = GroupPosts::find($id);
                $response = [
                    "toggle" => auth()->user()->liked_group_posts()->toggle($gp), 
                    "like_count" => $gp->liked_by->count()
                ]; 
                break;
        }

    	return $response;
    }

}
