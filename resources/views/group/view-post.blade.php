@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
		<div class="card-header p-3 bg-dark text-light" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
			<div class="d-flex justify-content-between pr-2">
				<div class="d-flex align-items-center">
					<a href="{{ route('profile.show', $gp->user_id) }}"><img  class="mr-3" src="{{ App\User::find($gp->user_id)->profile->profileImage() }}" width="50" height="50" style="border-radius: 50%;"></a>
					<strong>
						<a style="text-decoration: none; color: white;" href="{{ route('profile.show', $gp->user_id) }}"><strong>{{ App\User::find($gp->user_id)->name }}</strong></a> posted {{ $gp->created_at->diffForHumans() }}
					</strong>
				</div>
				@if($gp->user_id == Auth::id())
				<div class="d-flex align-items-center">
					@if($gp->attachment != null)
					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Edit post</a> &nbsp|&nbsp
					@elseif($gp->files != null)        					
					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Edit post</a> &nbsp|&nbsp
					@else
						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Add images</a> &nbsp|&nbsp
						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Add files</a> &nbsp|&nbsp
					@endif
					<a style="text-decoration: none; color: red;" onclick="return confirm('Do you want to delete this post?')" href="{{ route('group.groupPost-delete', $gp) }}">Delete</a>
				</div>
				@endif
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

				<like-component id="{{ $gp->id }}" likes="{{ $likes }}" type="{{ $type }}"></like-component>

				<form>
					<div class="form-group">
						<input type="text" name="comment" placeholder="Comment..." required>
						<button class="btn btn-warning">Comment</button>
					</div>
				</form>

			</div>
    	</div>
   	</div>
</div>
@endsection