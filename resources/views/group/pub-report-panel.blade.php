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
		  @if(!$group->privacy)
		  <li class="nav-item">
		        <a class="nav-link" href="{{ route('group.requests-panel', $group) }}">
		        	Requests: 
		        	@if( $group->unreadNotifications()->where('type', 'App\Notifications\group_join_request')->get()->count() > 0 )
		    			<small class="text-light px-2" style="background-color: red; border-radius: 50%;">
		    				<strong>{{ $group->unreadNotifications()->where('type', 'App\Notifications\group_join_request')->get()->count() }}</strong>
		    			</small>
		    		@endif
		    	</a>
		  </li>
		  <li class="nav-item">
		        <a class="nav-link active" href="{{ route('group.pub-reports-panel', $group) }}">
		        	Reports: 
		    	</a>
		  </li>
		  @else
		  <li class="nav-item">
		  		<a class="nav-link" href="{{ route('group.priv-reports-panel', $group) }}">
		        	Reports: 
		    	</a>
		  </li>
		  @endif
		</ul>
	</div>
	<hr>

	<!-- Refactor this -->
	<h3>Pending reports</h3>
	<hr>
	
	@forelse($pub_report_notif as $notif)
	<div class="card" style="border-radius: 2rem;">
		<div class="card-body d-flex align-items-center justify-content-between">
			<div>
				<p class="my-1 ml-3"><a href="{{ route('profile.show', $notif->data['sender']) }}">{{ App\User::find($notif->data['sender'])->name }}</a> reported <a href="{{ route('group.view-post', $notif->data['gp']) }}">{{ substr(App\GroupPosts::find($notif->data['gp'])->content, 0, 20) . "..." }}</a></p>
			</div>
			
			<div>
				<?php 
					$read = ($notif->read_at != null) ? true : false; 
				?>

				@if(!$read)
				<a href="{{ route('group.noti-mar', $notif) }}">Mark as read</a>
				@else
				<a href="{{ route('group.noti-rmv', $notif) }}">Remove</a>					
				@endif
			</div>
		</div>
	</div>
	@empty
		No reports so far...
	@endforelse
	
	<!-- refactor this -->
	@else
	<div class="container">
		Naughty, naughty...you shouldn't be here.	
	</div>
	

</div>
@endif
@endsection