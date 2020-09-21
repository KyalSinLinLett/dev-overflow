@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card p-4">

		@if(session()->has('success'))
			<div id="message_id" class="card px-4 py-4 bg-success text-light">
				{{ session()->get('success') }}
			</div>
		@endif
		@if(session()->has('error'))
			<div id="message_id" class="card px-4 py-4 bg-danger text-light">
				{{ session()->get('error') }}
			</div>
		@endif

		<div class="d-flex align-items-center justify-content-between">
			<h2>Edit your post</h2>
		<?php $group = App\GroupPosts::find($gp->id)->group; ?>
			<a href="{{ route('group.home', $group) }}"><small>Go back to group</small></a>
		</div>

		<hr>
		<form action="{{ route('group.update-content-img') }}" method="post" enctype="multipart/form-data">
			
			@csrf

			<input type="hidden" name="gp_id" value="{{ $gp->id }}">

			<div class="form-group">
				<textarea name="content" class="form-control mb-3" cols="50" rows="5" placeholder="Share something..." required>{{ $gp->content }}</textarea> 
			</div>

			<p>Current photos</p>
			
			@if(json_decode($gp->attachment, $assoc=true) != null)
			    @foreach(json_decode($gp->attachment, $assoc=true) as $att)
				    <div class="card">
				    	<div class="d-flex align-items-center justify-content-between px-3 py-2">
				    		<img src="{{ '/storage/' . $att}}" width="70" height="70">
				    		<?php $file_name = substr($att, 18); ?>
				    		<a href="{{ route('group.remove-img', [$file_name, $gp]) }}">Remove</a>
				    	</div>
				    </div>
				@endforeach
			@else
				<div>
					No images... add some?
				</div>
		    @endif

		    <div class="form-group mt-3">
		    	<label for="add-img">Add images</label>
		    	<input id="add-img" type="file" accept="image/*" name="attachment[]" class="form-control mb-3" multiple>
		    </div>

			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-info form-control" value="Update">
			</div>
		</form>
	</div>
</div>
@endsection