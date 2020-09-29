@extends('layouts.app')

@section('content')
<div class="container">

	@if(session()->has('success'))
		<div class="card text-light bg-success px-4 py-3">
				{{ session()->get('success') }}
		</div>
	@endif

	<h2>Send invites to your friends</h2>
	<hr>

	<div class="d-flex">
		<input type="text" id="search-user" name="{{ $group->id }}" class="form-control" placeholder="Enter a user's name to look for them">
		<button class="btn text-light" style="background: #52919b;" id="clearbtn2">Clear</button>
	</div>

	<table class="table">
		<tbody id="dyn-users-row">
			<tr><td><div class="card px-4 py-2" style="border-radius: 2rem;">Type something in the search bar...</div></td></tr>
		</tbody>
	</table>

</div>
@endsection