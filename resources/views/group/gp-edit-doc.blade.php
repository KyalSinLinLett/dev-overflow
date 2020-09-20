@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<form method="" action="post" enctype="multipart/form-data">
			@csrf

			<input type="hidden" name="gp_id" value="{{ $gp->id }}">

			<div class="form-group">
				<textarea name="content" class="form-control mb-3" cols="50" rows="5" placeholder="Share something..." required>{{ $gp->content }}</textarea> 
			</div>

			<p>Current files</p>
  			@foreach(json_decode($gp->files) as $file)
	  			<div class="ml-3">
	  				<?php
	  					$file_name = explode('@', $file)[1];
	  				?>
	  				<p><b>#</b> <a onclick="return confirm('Do you want to download this file?')" href="{{ '/group/file-download/' . $file }}"><strong>{{ $file_name }}</strong></a></p>
	  			</div>
			@endforeach

			<a href="">Add</a>
			<a href="">Remove</a>

			<div>
				<input type="submit" name="submit" class="btn btn-primary form-control" value="Update">
			</div>
		</form>
	</div>
</div>
@endsection