<div>
	<h1>Public feed</h1>
</div>
<hr>
@forelse($posts as $post)
<div class="card p-4 mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">

    <div class="row">
        <div class="col justify-content-between align-items-center mx-2 row">
            <div>
            	<img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
            	
            	<a href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px;" class="mt-3 ml-3">{{ $post->user->name }}</strong></a>


    	    	<strong class="ml-3" style="font-size: 16px; border-left: 1px solid; padding-left: 15px;">
    	    		{{$post->user->profile->followers->count()}}
    	    		<?php 
    	    		    $follower = "follower";
    	    		    if ($post->user->profile->followers->count() > 1){
    	    		        $follower = "followers";
    	    		    }?>
    	    		    {{$follower}}
    	    	</strong>

            </div>

        	@can('update', $post->user->profile)
        	    <strong><a href="{{ route('post.edit', $post) }}">Edit post</a></strong>
        	@endcan

        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col">
            <div class="mt-3">
            	<a href="{{ route('post.show', $post) }}"><h4>{{ $post->title }}</h4></a>
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

    <div class="row mt-3">
        <div class="col">
            <like-component pid="{{ $post->id }}" user="{{ auth()->user()->id }}" likes="{{ auth()->user()->liked_posts->contains($post->id) ?? false }}" type="{{ 'post' }}"></like-component>
        </div>
    </div>
</div>
@empty
    Such empty...
@endforelse
