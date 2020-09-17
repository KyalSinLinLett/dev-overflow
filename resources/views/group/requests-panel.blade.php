@extends('layouts.app')

@section('content')
<!-- use ajax in the future to make it async -->
<div class="container">
	@if($group->admin->contains(Auth::user()->profile))
	<h2>{{ $group->name }}'s admin panel<h2>
	
	<small>Manage group posts and members here.</small>
	<small><a href="{{ route('group.home', $group) }}">Back to group</a></small>
	<hr>

	<div>
		<ul class="nav nav-tabs">
		  <li class="nav-item">
		    <a class="nav-link" href="{{ route('group.post-panel', $group) }}">Posts</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="{{ route('group.member-panel', $group) }}">Members</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="{{ route('group.admin-panel', $group) }}">Admins</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="{{ route('group.requests-panel', $group) }}">
		    	Requests: 
		    	@if( $group->unreadNotifications()->get()->count() > 0 )
					<small class="text-light px-2" style="background-color: red; border-radius: 50%;">
						<strong>{{ $group->unreadNotifications()->get()->count() }}</strong>
					</small>
				@endif
			</a>
		  </li>
		</ul>
	</div>
	<hr>

	<!-- Refactor this -->
	<h3>Pending requests</h3>
	<hr>
	
	@forelse($group->notifications as $notif)
	<div class="card p-3 text-white bg-light mb-3" style="border-radius: 2rem;">
		<div class="d-flex align-items-center pl-2 justify-content-between">
			<div>
				<img src="{{ App\User::find($notif->data['user']['id'])->profile->profileImage() }}" width="50" height="50" style="border-radius: 50%; margin-right: 20px;">
				<strong><a style="font-size: 20px;" href="{{ route('profile.show', $notif->data['user']['id']) }}">{{ $notif->data['user']['name'] }}</a></strong>
			</div>
			
			<div>
				<a class="btn btn-success mr-4" style="font-size: 17px;" href="{{ route('group.approve-request', [$group, $notif->data['user']['id'], $notif]) }}">Approve</a>
			</div>
		</div>
	</div>
	@empty
		<p><marquee> Tell some of your friends to join this group! </marquee></p>
	@endforelse
	
	<!-- refactor this -->
	@else
	<div class="container">
		Naughty, naughty...you shouldn't be here.	
	</div>
	

</div>
@endif
@endsection