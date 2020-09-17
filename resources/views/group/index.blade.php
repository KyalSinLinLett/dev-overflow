@extends('layouts.app')

@section('content')
<div class="container">

	<div>
		<form action="{{ route('group.create') }}" method="post">
			@csrf
			<h3>Create group</h3>

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
				<button type="submit" class="btn btn-primary">Create</button>
			</div>
		</form>
	</div>

	<hr>

	<div>
		<h3>Your groups</h3>
		@forelse($groups as $group)
			<div class="card">
				<div class="card-header d-flex align-items-center">
					<img src="{{ $group->groupImage() }}" width="35" height="35">
					<p>Group: <a href="{{ route('group.home', $group)}}">{{ $group->name }}</a> 

						@if( $group->unreadNotifications()->get()->count() > 0 )
							<small class="text-light px-1" style="background-color: red; border-radius: 50%;"><strong>{{ $group->unreadNotifications()->get()->count() }}</strong></small>
						@endif
				</div>
				<div class="card-body">
					<p>Category: {{ $group->category }}</p>
					<p>Privacy: {{ $group->privacy }}</p>
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