	@extends('layouts.app')

@section('content')
<!-- use ajax in the future to make it async -->
<div class="container">
	@if($group->admin->contains(Auth::user()->profile))
	
	@if(session()->has('success'))
		<div class="card text-light bg-success px-4 py-3">
			{{ session()->get('success') }}
		</div>
	@endif

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
		        <a class="nav-link" href="{{ route('group.pub-reports-panel', $group) }}">
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

	<h3>Admins</h3>
	<hr>

	<!-- Refactor this -->
	<div>
		<h5>Send invites to people to join your group</h5>		

		<div class="d-flex">
			<input type="text" id="search-user-private" name="{{ $group->id }}" class="form-control" placeholder="Enter a user's name to look for them">
			<button class="btn btn-warning" id="clearbtn3">Clear</button>
		</div>

		<table class="table">
			<tbody id="dyn-users-row-private">
				<tr><td><div class="card px-4 py-2" style="border-radius: 2rem;">Type something in the search bar...</div></td></tr>
			</tbody>
		</table>
	</div>

	<div>
	    <table class="table">
	      <thead class="thead-dark">
	        <tr>
	          <th>Admin's name</th>
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
