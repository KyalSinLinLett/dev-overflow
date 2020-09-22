@extends('layouts.app')

@section('content')
<!-- use ajax in the future to make it async -->
@if($group->admin->contains(Auth::user()->profile))
<div class="container">
	<h2>{{ $group->name }}'s admin panel<h2>
	<small>Manage group posts and members here.</small>
	<small><a href="{{ route('group.home', $group) }}">Back to group</a></small>
	<hr>

	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active" href="{{ route('group.post-panel', $group) }}">Posts</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('group.member-panel', $group) }}">Members</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="{{ route('group.admin-panel', $group) }}">Admins</a>
	  </li>
	  @if(!$group->privacy)
	  <li class="nav-item">
	        <a class="nav-link" href="{{ route('group.requests-panel', $group) }}">
	        	Requests: 
	        	@if( $group->unreadNotifications()->where('type', 'App\Notifications\group_join_request')->get()->count() > 0 )
	    			<small class="text-light px-2" style="background-color: red; border-radius: 50%;">
	    				<strong>{{ $group->unreadNotifications()->where('type', 'App\Notifications\group_join_request')->get()->count() }}</strong>
	    			</small>
	    		@endif
	    	</a>
	  </li>
	  <li class="nav-item">
	        <a class="nav-link" href="{{ route('group.pub-reports-panel', $group) }}">
	        	Reports: 
	    	</a>
	  </li>
	  @else
	  <li class="nav-item">
	        <a class="nav-link" href="{{ route('group.priv-reports-panel', $group) }}">
	        	Reports: 
	    	</a>
	  </li>
	  @endif
	</ul>
	<hr>
	<!-- Refactor this -->
	<h3>Posts</h3>
	<hr>
	<div class="d-flex">
		<input type="text" id="search-post" name="{{ $group->id }}" class="form-control" placeholder="Enter a post's name to search">
		<button class="btn btn-warning" id="clearbtn4">Clear</button>
	</div>
	
	<br>
	<div>
	    <table class="table">
	      <thead class="thead-dark">
	        <tr>
	          <th>#</th>
	          <th>Post content</th>
	          <th>Posted by</th>
	          <th>Status</th>
	          <th>Type</th>
	          <th>Posted at</th>
	          <th>Likes</th>
	          <th>Comments</th>
	          <th>Actions</th>
	        </tr>
	      </thead>
	      <tbody id="dyn-row-posts">
	      	@forelse($group->group_posts as $gp)
	        <tr>
	        	<td>{{$gp->id}}</td>
	        	<td><a href="{{ route('group.view-post', $gp) }}">{{substr($gp->content, 0, 20) . "..."}}</a></td>
	        	<td><a href="{{ route('profile.show', $gp->user_id) }}">{{ App\User::find($gp->user_id)->name }}</a></td>
	        	<?php $status = ($group->member->contains(App\User::find($gp->user_id)->profile)) ? "M" : "A"  ?>
	        	
	        	<td>{{ $status }}</td>
	        	@if($gp->attachment != null)
	        		<td>Images</td>
	        	@elseif($gp->files != null)
	        		<td>Files</td>
	        	@else
	        		<td>No attachments</td>
	        	@endif
	        	
	        	<td>{{ $gp->created_at->diffForHumans() }}</td>
	        	<td>{{ $gp->liked_by->count() }}</td>
	        	<td>{{ $gp->gp_comments->count() }}</td>
	        	<td><a onclick="return confirm('Are you sure you want to delete this post?')" href="{{ route('group.groupPost-delete', $gp->id) }}">Remove post</a></td>
	        </tr>
	        @empty
	           <td>No posts</td>
	        @endforelse
	      </tbody>
	    </table>
		
	</div>
	<!-- refactor this -->
	@else
	<div class="container">
		Naughty, naughty...you shouldn't be here.
	</div>
</div>
@endif
@endsection
