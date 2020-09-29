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
		<div class="card" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
			<div class="card-header bg-dark d-flex align-items-center" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
				<a href="{{ route('group.home', $g_member)}}"><img src="{{ $g_member->groupImage() }}" width="50" height="50" style="border-radius: 50%"></a>
				<p class="ml-3 mt-3"><strong class="text-light">Group: <a class="text-light" href="{{ route('group.home', $g_member)}}">{{ $g_member->name }}</a></strong>
				</p>
			</div>
			<div class="card-body">
				<p>Category: {{ $g_member->category }}</p>
				<p>Privacy: 
					@if($g_member->privacy)
						Private
					@else
						Public
					@endif
				</p>
				<p>Description: {{ $g_member->description }}</p>
				<small>Admins: 
					@foreach($g_member->admin as $admin)
					{{ App\User::find($admin->user_id)->name }} | 
					@endforeach
				</small>
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
