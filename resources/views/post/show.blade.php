@extends('layouts.app')

@section('content')
<div class="container">

	@if(session()->has('message'))
	<div class="card px-3 py-3 bg-info">{{session()->get('message')}}</div>
	@endif

	<div>
		<h1>View Post</h1>
	</div>
	<hr>

	<div class="card p-4 mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">

	    <div class="row">
	        <div class="col justify-content-between align-items-center mx-2 row">
	            <div class="d-flex">
	            	<img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
	            	<div>
	            		<a href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px;" class="mt-3 mr-4 ml-3">{{ $post->user->name }}</strong></a>
	            	</div>
	            	<div style="border-left: 1px solid; padding-left: 15px;">
	            	    <div>
	            	    	<strong class="ml-3">
	            	    		{{$post->user->profile->followers->count()}}
	            	    		<?php 
	            	    		    $follower = "follower";
	            	    		    if ($post->user->profile->followers->count() > 1){
	            	    		        $follower = "followers";
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
	                <h4>{{ $post->title }}</h4>
	            </div>
	            <div>
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
	    </div>

	    <div class="row">
	    	<div class="col">
	    		<?php $user = auth()->user()->id ;?>
	    		<form action="{{ route('comment', [$post, $user]) }}" method="POST">
	    			@csrf
    				<div class="mt-2 mb-3">
    					<div class="row">
    						<div class="col-7">
    							<input id="comment" 
    							       type="text" 
    							       name="comment"
    							       class="form-control @error('comment') is-invalid @enderror" 
    							       value="{{ old('comment') ?? $post->comment }}" 
    							       autocomplete="comment" 
    							       placeholder="Enter your comment" 
    							       required autofocus>

    							@error('comment')
    							     <strong>{{ $message }}</strong>
    							@enderror
    						</div>
    						<div class="col">
    							<button class="btn btn-warning btn-block"><strong>Comment</strong></button>
    						</div>
    					</div>
    				</div>

	    		</form>
	    	</div>
	    </div>

	    <div class="rows">
	    	<div class="col d-flex">
	    		<like-component pid="{{ $post->id }}" user="{{ auth()->user()->id }}" likes="{{ $likes }}" type="{{ $type }}"></like-component>

	    		@if(!auth()->user()->shared_posts->contains($post))
	    			<?php $user = auth()->user(); ?>
	    			<a class="btn btn-outline-primary btn-block" href="{{ route('post.share', [$post, $user]) }}">Save post</a>
	    		@endif
	    	</div>
	    </div>
	</div>

	<div>
		<h3>Comments</h3>
	</div>
	<hr>

	<div class="row mb-4">
		<div class="col">
			<?php use App\User;?>
			@foreach($post->comments as $comment)
			<div class="card p-3 mb-2"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
				<?php $user = User::find($comment->user_id); ?>
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<img src="{{ $user->profile->profileImage() }}" class="rounded-circle mr-2" width="50" height="50">
						<i>{{ $comment->comment }}</i>
					</div>

					<div>
						@can('update', $user->profile)
						<div>
							<a href="{{ route('comment.edit', $comment)}}">Edit</a>
							<a href="{{ route('comment.delete', $comment) }}">Delete</a>
						</div>
						@endcan
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>

</div>
@endsection('content')