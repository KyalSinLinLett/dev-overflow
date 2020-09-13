@extends('layouts.app')

@section('content')
<div class="container">
	<form action="{{ route('group.update', $group) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="align-items-center justify-content-between d-flex">
			<h3>Edit group details</h3>
		</div>

		<div class="form-group">
			<input type="text" name="name" placeholder="Group name" class="form-control" value="{{ $group->name }}" required>
		</div>

		<div class="form-group">
			<textarea name="description" cols="10" rows="5" placeholder="Description" class="form-control" required>{{ $group->description }}</textarea>
		</div>

		<div class="form-group">
			<input type="file" name="groupPhoto" accept="image/*s">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-info">Update</button>
		</div>
	</form>
</div>
@endsection