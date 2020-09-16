@extends('layouts.app')

@section('content')
<!-- use ajax in the future to make it async -->
<div class="container">
	@if($group->admin->contains(Auth::user()->profile))
	<h2>{{ $group->name }}'s admin panel<h2>
	<small>Manage group posts and members here.</small>
	<hr>

	<div>
		<ul class="nav nav-tabs">
		  <li class="nav-item">
		    <a class="nav-link" href="{{ route('group.post-panel', $group) }}">Posts</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link active" href="{{ route('group.member-panel', $group) }}">Members</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" href="{{ route('group.admin-panel', $group) }}">Admins</a>
		  </li>
		</ul>
	</div>
	<hr>

	<!-- Refactor this -->
	<h3>Members</h3>
	<hr>
	<div class="d-flex">
		<input type="text" id="search-member" name="{{ $group->id }}" class="form-control" placeholder="Enter a member's name to search them">
		<button class="btn btn-warning" id="clearbtn">Clear</button>
	</div>
	
	<br>
	<div>
	    <table class="table">
	      <thead class="thead-dark">
	        <tr>
	          <th>Name</th>
	          <th>Profession</th>
	          <th>Actions</th>
	        </tr>
	      </thead>
	      <tbody id="dyn-row">
	      	@forelse ($group->member as $member)
	        <tr>
	          <td class="d-flex align-items-center"><img src="{{ $member->profileImage() }}" width="35" height="35" style="border-radius: 50%;"><a href="{{ route('profile.show', $member->user) }}"><strong class="ml-3">{{ $member->user->name }}</strong></a></td>
	          <td>{{ $member->profession }}</td>
	          <td>
	          	<a onclick="return confirm('Are you sure you want to make this member an admin?');" href="{{ route('group.makeadmin', [$member, $group]) }}">Make admin</a> | 
	            <a onclick="return confirm('Are you sure you want to remove this member?');" href="{{ route('group.remove-member', [$member, $group]) }}">Remove member</a>
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