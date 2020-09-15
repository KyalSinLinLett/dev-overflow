@extends('layouts.app')

@section('content')
<div class="container">

	<h3>Groups where {{ $user->name }} is a member</h3>
	<small>Note: This page only shows public groups.</small>
	<hr>
	<ul class="nav nav-tabs">
		<li class="nav-item">
		<a class="nav-link" href="{{ route('profile.create-groups', $user) }}">{{ $user->name }}'s groups</a>
		</li>
		<li class="nav-item">
		<a class="nav-link active" href="{{ route('profile.member-groups', $user) }}">{{ $user->name }}'s joined groups</a>
		</li>
	</ul>
	<br>
	@forelse($p_member as $g_member)	
		<div class="card">
			<div class="card-header d-flex">
				<img src="{{ $g_member->groupImage() }}" width="35" height="35">
				<p>Group: <a href="{{ route('group.home', $g_member)}}">{{ $g_member->name }}</a></p>
			</div>
			<div class="card-body">
				<p>Description: {{ $g_member->description }}</p>
			</div>
		</div>
		<br>
	@empty
	<div>
		Such empty...
	</div>
	@endforelse
	
</div>
@endsection
