@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h3>Groups I've joined</h3>
		<hr>

		<div class="d-flex">
		    <input type="text" id="search-group" class="form-control" placeholder="look for groups to join..">
		    <button class="btn text-light" style="background: #52919b;" id="clearbtn6">Clear</button>
		</div>

		<table class="table">
		    <tbody id="dyn-grp-search">

		    </tbody>
		</table>

		@forelse($groups as $group)
			<div class="card" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
				<div class="card-header bg-dark d-flex align-items-center" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
					<a href="{{ route('group.home', $group)}}"><img src="{{ $group->groupImage() }}" width="50" height="50" style="border-radius: 50%"></a>
					<p class="ml-3 mt-3"><strong class="text-light">Group: <a class="text-light" href="{{ route('group.home', $group)}}">{{ $group->name }}</a></strong>
					</p>
				</div>
				<div class="card-body">
					<p>Category: {{ $group->category }}</p>
					<p>Privacy: 
						@if($group->privacy)
							Private group
						@else
							Public group
						@endif
					</p>
					<p>Description: {{ $group->description }}</p>
					<small>Admins: 
						@foreach($group->admin as $admin)
						{{ App\User::find($admin->user_id)->name }} | 
						@endforeach
					</small>
				</div>
			</div>
			<br>
		@empty
			Such Empty...
		@endforelse
	</div>
</div>
@endsection