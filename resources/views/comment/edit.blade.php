@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row mt-4">
	    <div class="col">
	        <div class="card p-4" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	        	<h3>Edit comment</h3>
	            <form action="{{ route('comment.update', $comment) }}" method="POST">
	                @csrf
	                <div class="mt-2 mb-3">
	                	<div class="row">
	                		<div class="col-8">
	                			<input id="comment" 
	                			       type="text" 
	                			       name="comment"
	                			       class="form-control @error('comment') is-invalid @enderror" 
	                			       value="{{ old('comment') ?? $comment->comment }}" 
	                			       autocomplete="comment" 
	                			       placeholder="Enter your comment" 
	                			       required autofocus>

	                			@error('comment')
	                			     <strong>{{ $message }}</strong>
	                			@enderror
	                		</div>
	                		<div class="col">
	                			<button class="btn btn-outline-info btn-block"><strong>Update</strong></button>
	                		</div>
	                	</div>
	                </div>

	            </form>
	        </div>
	    </div>
	</div>
</div>
@endsection('content')