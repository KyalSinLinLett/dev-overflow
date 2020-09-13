@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h3>Groups I've joined</h3>
		<hr>
		@forelse($groups as $group)
			<div class="card">
				<div class="card-header">
					<p>Group: <a href="{{ route('group.home', $group)}}">{{ $group->name }}</a></p>
				</div>
				<div class="card-body">
					<p>Category: {{ $group->category }}</p>
					<p>Privacy: {{ $group->privacy }}</p>
					<p>Description: {{ $group->description }}</p>
				</div>
			</div>
			<br>
		@empty
			Such Empty...
		@endforelse
	</div>
</div>
@endsection