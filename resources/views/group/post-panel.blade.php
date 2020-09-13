@extends('layouts.app')

@section('content')
@if($group->admin->contains(Auth::user()->profile))
<div class="container">
	<h2>{{ $group->name }}'s admin panel<h2>
	<small>Manage group posts and members here.</small>
	<hr>

	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active" href="{{ route('group.post-panel', $group) }}">Posts</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('group.member-panel', $group) }}">Members</a>
	  </li>
	</ul>
</div>
@else
<div class="container">
	Naughty...naughty	
</div>
@endif
@endsection
