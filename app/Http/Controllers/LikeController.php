<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class LikeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function store(Post $post)
    {
    	$response = [
    		"toggle" => auth()->user()->liked_posts()->toggle($post), 
    		"like_count" => $post->liked_by->count()
    	];

    	return $response;
    }
}
