@extends('layouts.app')

@section('content')
<div class="container">
	@can('view', $post->user->profile)
	<div class="row mt-4">
	    <div class="col">
	        <div class="card p-4" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	            <form action="{{ route('post.update', $post) }}" enctype="multipart/form-data" method="post">
	                @csrf

	                <div class="d-flex justify-content-between">
	                    <h4>Edit Post</h4>

	                    <strong><a href="{{ route('post.delete', $post) }}">Delete Post</a></strong>
	                </div>

	                <div class="mt-3">
	                    <input id="title" 
	                           type="text" 
	                           name="title"
	                           class="form-control @error('title') is-invalid @enderror" 
	                           value="{{ old('title') ?? $post->title }}" 
	                           autocomplete="title" 
	                           placeholder="Title" 
	                           required autofocus>

	                    @error('title')
	                         <strong>{{ $message }}</strong>
	                    @enderror
	                </div> 

	                <div class="mt-3">
	                    <textarea id="content" 
	                           type="text" 
	                           name="content"
	                           rows="6"
	                           class="form-control @error('content') is-invalid @enderror" 
	                           autocomplete="content" 
	                           placeholder="Share your thoughts" required autofocus>{{ $post->content }}</textarea>

	                    @error('profession')
	                         <strong>{{ $message }}</strong>
	                    @enderror
	                </div> 

	                <div class="mt-3">
	                    <div>
	                        <h5>Change</h5>
	                    </div>

	                    <input type="file" name="postimage" class="form-control-file" id="postimage">

	                    @error('postimage')
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $message }}</strong>
	                        </span>
	                    @enderror
	                </div>

	                <div class="mt-4">
	                    <div class="row">
	                        <div class="col-8 offset-2">
	                            <button class="btn btn-outline-primary btn-block"><strong>Update</strong></button>
	                        </div>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	@endcan
</div>
@endsection('content')