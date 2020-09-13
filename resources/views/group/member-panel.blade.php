@extends('layouts.app')

@section('content')
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
		</ul>
	</div>
	<hr>

	<!-- Refactor this -->
	<h3>Members</h3>
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
	      	@forelse ($group->member as $member)
	        <tr>
	          <td class="d-flex align-items-center"><img src="{{ $member->profileImage() }}" width="35" height="35" style="border-radius: 50%;"><a href="{{ route('profile.show', $member->user) }}"><strong class="ml-3">{{ $member->user->name }}</strong></a></td>
	          <td>{{ $member->profession }}</td>
	          <td>
	          	<a href="{{ route('group.makeadmin', [$member, $group]) }}">Make admin</a> | 
	            <a href="{{ route('group.remove-member', [$member, $group]) }}">Remove member</a>
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
