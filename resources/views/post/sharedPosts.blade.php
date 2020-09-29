@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h2>{{ $user->name }}'s saved Posts</h2>
	</div>
	<hr>

	@forelse($shared_posts as $post)
	<div class="card mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	    <div class="card-header p-3 text-light" style="background: #52919b; border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	        <div class="d-flex justify-content-between pr-2">
	            <div class="d-flex align-items-center">
	                <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
	                <a style="text-decoration: none;" href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px; color: white; text-decoration: none;" class="mt-3 ml-3">{{ $post->user->name }}</strong></a>
	            </div>
	            <div class="d-flex align-items-center">
	                <div>
    	            	@if(auth()->user()->shared_posts->contains($post))
    	            	    <strong><a style="text-decoration: none; color: white;" href="{{ route('post.shareremove', $post) }}">Remove</a></strong>
    	            	@endauth
    	            </div>
	            </div>
	        </div>
	    </div>

	    <div class="card-body pl-4 pr-4 pt-4 pb-2"> 
	        <a href="{{ route('post.show', $post) }}"><h4>{{ $post->title }}</h4></a>                        
	        
	        <article>
	            <p style="font-style: italic;">
	                {{ $post->content }}
	            </p>
	        </article>

	        @if($post->postimage)
	        <div class="row">
	            <div class="col my-2 mx-1">
	                <img src="{{ '/storage/' . $post->postimage }}" class="w-100">
	            </div>
	        </div>
	        @endif 
	    </div>
	</div>
	@empty
		<div>
			Such empty...
		</div>
	@endforelse
</div>
@endsection('content')