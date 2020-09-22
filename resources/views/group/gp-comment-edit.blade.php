@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row mt-4">
	    <div class="col">
	        <div class="card p-4" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	        	<h3>Edit comment</h3>
	            <form action="{{ route('group.gp-comment-update') }}" method="POST">
	                
	                @csrf

	                <input type="hidden" name="gp_cmt_id" value="{{ $gp_cmt->id }}">
	                <input type="hidden" name="gp_id" value="{{ $gp_cmt->group_posts_id }}">

	                <div class="mt-2 mb-3">
	                	<div class="row">
	                		<div class="col-8">
	                			<input id="comment" 
	                			       type="text" 
	                			       name="comment"
	                			       class="form-control" 
	                			       value="{{ $gp_cmt->comment }}" 
	                			       placeholder="Enter your comment" 
	                			       required>

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