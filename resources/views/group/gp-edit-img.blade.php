@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card p-4">
		<form method="{{ route('group.update-content-img') }}" action="post" enctype="multipart/form-data">
			
			@csrf

			<input type="hidden" name="gp_id" value="{{ $gp->id }}">

			<div class="form-group">
				<textarea name="content" class="form-control mb-3" cols="50" rows="5" placeholder="Share something..." required>{{ $gp->content }}</textarea> 
			</div>

			<p>Current photos</p>
			
			@if(json_decode($gp->attachment, $assoc=true) != null)
			    @foreach(json_decode($gp->attachment, $assoc=true) as $att)
				    <div class="card">
				    	{{ $att }}
				    	<div class="d-flex align-items-center justify-content-between px-3 py-2">
				    		<img src="{{ '/storage/' . $att}}" width="65" height="65">
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


			<a href="">Add</a>

			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-info form-control" value="Update">
			</div>
		</form>
	</div>
</div>
@endsection