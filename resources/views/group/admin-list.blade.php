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
		    <a class="nav-link active" href="{{ route('group.admin-panel', $group) }}">Admins</a>
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
	<hr>

	<!-- Refactor this -->
	<h3>Admins</h3>
	<hr>
	<div>
	    <table class="table">
	      <thead class="thead-dark">
	        <tr>
	          <th>Name</th>
	          <th>Profession</th>
	          <th>Actions</th>
	        </tr>
	      </thead>
	      <tbody>
	      	@forelse ($group->admin as $admin)
	        <tr>
	          <td class="d-flex align-items-center"><img src="{{ $admin->profileImage() }}" width="35" height="35" style="border-radius: 50%;"><a href="{{ route('profile.show', $admin->user) }}"><strong class="ml-3">{{ $admin->user->name }}</strong></a></td>
	          <td>{{ $admin->profession }}</td>
	          <td>
	            <a onclick="return confirm('Are you sure you want to remove this admin?');" href="{{ route('group.remove-admin', [$admin, $group]) }}">Remove admin</a>
	          </td>
	        </tr>
	        @empty
	           <td>No members yet</td>
	        @endforelse
	      </tbody>
	    </table>
		
	</div>
	<!-- refactor this -->
	@else
	<div class="container">
		Naughty, naughty...you shouldn't be here.	
	</div>
	

</div>

@endif
@endsection
