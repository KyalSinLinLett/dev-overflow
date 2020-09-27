@extends('layouts.app')

@section('content')
<div class="container">
	<h2>Notifications</h2>
	<hr>	
	<div>
		@forelse($notifications as $notif)
			<div class="card mb-3" style="border-radius: 2rem;">
				<div class="d-flex align-items-center justify-content-between px-4 py-2">

					@if($notif->type == 'App\Notifications\post_liked')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['liker_id'])) }}">{{ App\User::find($notif->data['liker_id'])->name }}</a> liked your post<a href="{{ route('post.show', $notif->data['post_id']) }}"> {{ App\Post::find($notif->data['post_id'])->title }}</a> {{ $notif->created_at->diffForHumans() }}</strong>
					@elseif($notif->type == 'App\Notifications\group_post_liked')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['liker_id'])) }}">{{ App\User::find($notif->data['liker_id'])->name }}</a> liked your <a href="{{ route('post.show', $notif->data['post_id']) }}"> post </a> in group <a href="{{ route('group.home', $notif->data['group_id']) }}">{{ App\Group::find($notif->data['group_id'])->name }} </a>{{ $notif->created_at->diffForHumans() }}</strong>
					@elseif($notif->type == 'App\Notifications\followed_user')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['follower_id'])) }}">{{ App\User::find($notif->data['follower_id'])->name }}</a> followed you {{ $notif->created_at->diffForHumans() }}</strong>
					@elseif($notif->type == 'App\Notifications\commented')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['commentor_id'])) }}">{{ App\User::find($notif->data['commentor_id'])->name }}</a> commented on your <a href="{{ route('post.show', $notif->data['post_id']) }}"> post</a> {{ $notif->created_at->diffForHumans() }}</strong>
					@elseif($notif->type == 'App\Notifications\group_post_commented')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['commentor_id'])) }}">{{ App\User::find($notif->data['commentor_id'])->name }}</a> commented on your <a href="{{ route('post.show', $notif->data['post_id']) }}"> post</a> in group <a href="{{ route('group.home', $notif->data['group_id']) }}">{{ App\Group::find($notif->data['group_id'])->name }}</a> {{ $notif->created_at->diffForHumans() }}</strong>
					@elseif($notif->type == 'App\Notifications\shared_post')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['sharer_id'])) }}">{{ App\User::find($notif->data['sharer_id'])->name }}</a> shared your <a href="{{ route('post.show', $notif->data['post_id']) }}"> post</a> {{ $notif->created_at->diffForHumans() }}</strong>
					@endif

	
					<?php 
						$read = ($notif->read_at != null) ? true : false; 
					?>

					@if(!$read)
					<a href="{{ route('group.noti-mar', $notif) }}">Mark as read</a>
					@else
					<a href="{{ route('group.noti-rmv', $notif) }}">Remove</a>					
					@endif
					
				</div>
			</div>
		@empty
			No new notifications
		@endforelse
	</div>
</div>
@endsection