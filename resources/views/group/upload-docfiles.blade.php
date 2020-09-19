@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between">
			<h3>
				Share file(s) to {{ $group->name }}
			</h3>
			<a href="{{ route('group.home', $group) }}"><small>Go back to group</small></a>
		</div>
		<div class="card-body">
			<form action="{{ route('group.save-docfiles') }}" method="POST" enctype="multipart/form-data" class="form-group">
				@csrf
				<input type="hidden" name="group_id" value="{{ $group->id }}">
				<textarea name="content" class="form-control mb-3" cols="50" rows="3" placeholder="Say something for about the file(s)..." required></textarea> 
				<input type="file" accept=".xlsx, .xls, .doc, .docx, .ppt, .pptx, .txt, .pdf, .zip" name="files[]" class="form-control mb-3" multiple required>
				<input type="submit" name="submit" class="btn btn-primary" value="Share">
			</form>
		</div>
	</div>
</div>
@endsection