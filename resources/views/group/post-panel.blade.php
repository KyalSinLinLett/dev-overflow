@extends('layouts.app')

@section('content')
<!-- use ajax in the future to make it async -->
@if($group->admin->contains(Auth::user()->profile))
<div class="container">
	<h2>{{ $group->name }}'s admin panel<h2>
	<small>Manage group posts and members here.</small>
	<small><a href="{{ route('group.home', $group) }}">Back to group</a></small>
	<hr>

	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active" href="{{ route('group.post-panel', $group) }}">Posts</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('group.member-panel', $group) }}">Members</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('group.admin-panel', $group) }}">Admins</a>
	  </li>
	  <li class="nav-item">
	        <a class="nav-link" href="{{ route('group.requests-panel', $group) }}">
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
@else
<div class="container">
	Naughty, naughty...you shouldn't be here.	
</div>
@endif
@endsection
