@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h2>Liked Posts</h2>
	</div>
	<hr>

	@foreach($posts as $post)
	<div class="card p-4 mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">

	    <div class="row">
	        <div class="col justify-content-between align-items-center mx-2 row">
	            <div class="d-flex">
	            	<img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
	            	<div>
	            		<a href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px; border-right: 1px solid; padding-right: 15px" class="mt-3 ml-3">{{ $post->user->name }}</strong></a>
	            	</div>
	            	<div>
	            	    <div>
	            	    	<strong class="ml-3">
	            	    		{{$post->user->profile->followers->count()}}
	            	    		<?php 
	            	    		    $follower = "follower";
	            	    		    if ($post->user->profile->followers->count() > 1){
	            	    		        $like = "followers";
	            	    		    }?>
	            	    		    {{$follower}}
	            	    	</strong>
	            	    </div>

	            	    <div>
	            	    	<strong class="ml-3">{{ $post->liked_by->count() }}  
	            	    	    <?php 
	            	    	        $like = "like";
	            	    	        if ($post->liked_by->count() > 1){
	            	    	            $like = "likes";
	            	    	        }?>
	            	    	        {{$like}}
	            	    	</strong>
	            	    </div>	            	    
	            	</div>
	            </div>

	            <div>
	            	@can('update', $post->user->profile)
	            	    <strong><a href="{{ route('post.edit', $post) }}">Edit post</a></strong>
	            	@endcan
	            </div>
	        </div>
	    </div>
	    <hr>

	    <div class="row">
	        <div class="col">
	            <div class="mt-3">
	                <h4><a href="{{ route('post.show', $post) }}">{{ $post->title }}</a></h4>
	            </div>
	            <div>
	                <article>
	                    <p style="font-style: italic;">
	                    	{{ $post->content }}
	                    </p>
	                </article>

	                @if($post->postimage)
	                <div class="row">
	                    <div class="col my-4 mx-1">
	                        <img src="{{ '/storage/' . $post->postimage }}" class="w-100">
	                    </div>
	                </div>
	                @endif 
	                
	            </div>
	        </div>
	    </div>
	</div>
	@endforeach
</div>
@endsection('content')