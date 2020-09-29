@extends('layouts.app')

@section('content')
<div class="container">

	<h2>Groups</h2>
	<hr>

	<div class="card" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
		<div class="card-header bg-dark text-light pt-4" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
			<h2>Create a group</h2>
		</div>

		<div class="card-body pb-1">
			<form action="{{ route('group.create') }}" method="post">
				@csrf
				
				<div class="form-group">
					<input type="text" name="name" placeholder="Group name" class="form-control" required>
				</div>

				<div class="form-group">
					<textarea name="description" cols="10" rows="5" placeholder="Description" class="form-control" required></textarea>
				</div>

				<div class="form-group">
					<input type="checkbox" id="p_check" name="privacy">
					<label for="p_check"> Make this group private</label><br>
				</div>
				
				<div class="form-group">
					<label for="category"> Pick a category that matches your group</label>
					<select name="category" id="category">
						<option value="STEM">STEM</option>
						<option value="Business">Business</option>
						<option value="Classroom">Classroom</option>
						<option value="General">General</option>
					</select>
				</div>
				
				<div class="form-group">
					<button type="submit" style="background: #52919b;" class="btn btn-primary">Create</button>
				</div>
			</form>
		</div>
		
	</div>

	<hr>

	<div>
		<h3>Your groups where you are admin</h3>
		<hr>
		@forelse($groups as $group)
			<div class="card" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
				<div class="card-header bg-dark d-flex align-items-center" style="border-radius: 2rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
					<a href="{{ route('group.home', $group)}}"><img src="{{ $group->groupImage() }}" width="50" height="50" style="border-radius: 50%"></a>
					<p class="ml-3 mt-3"><strong class="text-light">Group: <a class="text-light" href="{{ route('group.home', $group)}}">{{ $group->name }}</a></strong>

						@if( $group->unreadNotifications()->get()->count() > 0 )
							<small class="text-light px-1" style="background-color: red; border-radius: 50%;"><strong>{{ $group->unreadNotifications()->get()->count() }}</strong></small>
						@endif
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
@endsection('content')