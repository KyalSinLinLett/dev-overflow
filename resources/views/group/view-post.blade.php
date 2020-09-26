@extends('layouts.app')

@section('content')
<div class="container">
	<h2>View post</h2>
	<hr>
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
	
    <div class="card mb-3" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
		<div class="card-header p-3 bg-dark text-light" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
			<div class="d-flex justify-content-between pr-2">
				<div class="d-flex align-items-center">
					<a href="{{ route('profile.show', $gp->user_id) }}"><img  class="mr-3" src="{{ App\User::find($gp->user_id)->profile->profileImage() }}" width="50" height="50" style="border-radius: 50%;"></a>
					<strong>
						<a style="text-decoration: none; color: white;" href="{{ route('profile.show', $gp->user_id) }}"><strong>{{ App\User::find($gp->user_id)->name }}</strong></a> posted {{ $gp->created_at->diffForHumans() }}
					</strong>
				</div>
				<div class="d-flex align-items-center">
				@if($gp->user_id == Auth::id())
					@if($gp->attachment != null)
					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Edit post</a> &nbsp|&nbsp
					@elseif($gp->files != null)        					
					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Edit post</a> &nbsp|&nbsp
					@else
						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Add images</a> &nbsp|&nbsp
						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Add files</a> &nbsp|&nbsp
					@endif
					<a style="text-decoration: none; color: red;" onclick="return confirm('Do you want to delete this post?')" href="{{ route('group.groupPost-delete', $gp) }}">Delete</a>
				@else
					@if(App\Group::find($gp->group_id)->privacy)
					<a style="text-decoration: none; color: red;" href="{{ route('group.make-priv-report', $gp) }}">Report</a>
					@else
					<a style="text-decoration: none; color: red;" href="{{ route('group.make-pub-report', $gp) }}">Report</a>
					@endif
				@endif
				</div>
			</div>
		</div>
		<div class="card-body pl-4 pr-4 pt-2 pb-4"> 
			<a style="text-decoration: none; color: black;" href="{{ route('group.view-post', $gp) }}"><p class="pl-3 mt-3"><strong>{{ $gp->content }}</strong></p></a>
  			@if($gp->attachment != null)
  				@if(sizeof(json_decode($gp->attachment, $assoc=true)) > 1 )
    			<div id="carouselExampleControlsOri" class="carousel slide p-2" data-ride="carousel">
    			  <div class="carousel-inner">
    			  	<div class="carousel-item active">
    			  	  <img class="d-block w-100" src="{{ '/storage/' . json_decode($gp->attachment, $assoc=true)[0] }}">
    			  	</div>
    			    @foreach(json_decode($gp->attachment) as $att)
    				    @if($att != json_decode($gp->attachment, $assoc=true)[0])
    				    <div class="carousel-item">
    				      <img class="d-block w-100" src="{{ '/storage/' . $att }}">
    				    </div>
    				    @endif
    			    @endforeach
    			  </div>
    			  <a class="carousel-control-prev" href="#carouselExampleControlsOri" role="button" data-slide="prev">
    			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    			    <span class="sr-only">Previous</span>
    			  </a>
    			  <a class="carousel-control-next" href="#carouselExampleControlsOri" role="button" data-slide="next">
    			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    			    <span class="sr-only">Next</span>
    			  </a>
    			</div>
    			@else
    				<div>
    					<img class="d-block w-100" src="{{ '/storage/' . json_decode($gp->attachment, $assoc=true)[0] }}">
    				</div>
    			@endif
			@elseif($gp->files != null)
  			@foreach(json_decode($gp->files) as $file)
	  			<div class="ml-3">
	  				<p><b>#</b> <a onclick="return confirm('Do you want to download this file?')" href="{{ '/group/file-download/' . $file }}"><strong>{{ explode('@', $file)[1] }}</strong></a></p>
	  			</div>
			@endforeach
			@endif

			<div class="d-flex">

				<like-component pid="{{ $gp->id }}" user="{{ auth()->user()->id }}" likes="{{ $likes }}" type="{{ $type }}"></like-component>

				<form action="{{ route('group.gp-comment', $gp) }}" method='POST'>
					@csrf
					<div class="form-group">
						<input type="text" name="comment" placeholder="Comment..." required>
						<button type="submit" class="btn btn-warning">Comment</button>
					</div>
				</form>

			</div>
    	</div>
   	</div>

	@forelse($gp->gp_comments as $gp_cmt)
		<div class="card px-3 py-3 mb-3" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
			<div class="d-flex align-items-center justify-content-between">
				<div>
					<a href="{{ route('profile.show', $gp_cmt->user_id) }}"><img class="mr-3" src="{{ App\User::find($gp_cmt->user_id)->profile->profileImage() }}" width="50" height="50" style="border-radius: 50%;"></a>
					<a href="{{ route('profile.show', $gp_cmt->user_id) }}">{{ App\User::find($gp_cmt->user_id)->name }}</a> - 
					{{ $gp_cmt->comment }}
				</div>
				
				<div>
					@if($gp_cmt->user_id == Auth::id())
						<a href="{{ route('group.gp-comment-edit', $gp_cmt) }}">Edit</a> &nbsp|&nbsp
						<a onclick="return confirm('Are you sure you want to delete this comment?')" href="{{ route('group.gp-comment-delete', $gp_cmt) }}">Delete</a> &nbsp|&nbsp
					@endif

					<small>{{ $gp_cmt->created_at->diffForHumans() }}</small>
				</div>
			</div>
			
		</div>
	@empty
	@endforelse

</div>
@endsection