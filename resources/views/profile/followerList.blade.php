@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h1>Followers</h1>
	</div>
	<hr>

	<?php use App\User;?>
	@foreach($followers as $follower)
	<div class="card p-3 mb-2"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
		<?php $user = User::find($follower->profile->user->id); ?>
		<div class="row align-items-center mx-2">
			<img src="{{ $follower->profile->profileImage() }}" class="rounded-circle mr-3" width="50" height="50">
			<a href="{{ route('profile.show' , $user) }}"><b style="font-size: 20px;">{{ $follower->name }}</b></a>
		</div>
	</div>
		
	@endforeach
</div>
@endsection