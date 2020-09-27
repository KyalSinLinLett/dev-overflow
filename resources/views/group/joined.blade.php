@extends('layouts.app')

@section('content')
<div class="container">
	<div>
		<h3>Groups I've joined</h3>
		<hr>

		<div class="d-flex">
		    <input type="text" id="search-group" class="form-control" placeholder="look for groups to join..">
		    <button class="btn btn-warning" id="clearbtn6">Clear</button>
		</div>

		<table class="table">
		    <tbody id="dyn-grp-search">

		    </tbody>
		</table>


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