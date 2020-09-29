@extends('layouts.app')

@section('content')

<div class="container">
	<div>
		<h1>Private feed</h1>
	</div>
	<hr>
	@forelse($posts as $post)
	<div class="card mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">

		<div class="card-header p-3 text-light" style="background: #52919b; border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
		    <div class="d-flex justify-content-between pr-2">
		        <div class="d-flex align-items-center">
		            <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
		            <a style="text-decoration: none;" href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px; color: white; text-decoration: none;" class="mt-3 ml-3">{{ $post->user->name }}</strong></a>

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
		        <div class="d-flex align-items-center">
		            @can('update', $post->user->profile)
		                <strong><a style="color: white; text-decoration: none;" href="{{ route('post.edit', $post) }}">Edit post</a></strong>
		            @endcan
		        </div>
		    </div>
		</div>

		<div class="card-body pl-4 pr-4 pt-4 pb-2"> 
			<div class="d-flex align-items-center justify-content-between">
				<a href="{{ route('post.show', $post) }}"><h4>{{ $post->title }}</h4></a>                        
				<strong> - {{ $post->created_at->diffForHumans() }} </strong>               
			</div>
		    
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

		    <div class="row mt-3 mb-3">
		        <div class="col">
		            <like-component pid="{{ $post->id }}" user="{{ auth()->user()->id }}" likes="{{ auth()->user()->liked_posts->contains($post->id) ?? false }}" type="{{ 'post' }}"></like-component>
		        </div>
		    </div>
		</div>
	</div>
	@empty
	<div>
		Such empty...
	</div>
	@endforelse

</div>

@endsection