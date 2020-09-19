@extends('layouts.app')

@section('content')
<div class="container">
	<h2>Group notifications</h2>
	<hr>	
	<div>

		@forelse($notifications as $notif)
			<div class="card mb-3" style="border-radius: 2rem;">
				<div class="d-flex align-items-center justify-content-between px-4 py-2">

					@if($notif->type == 'App\Notifications\join_request_approved')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['user'])) }}">{{ App\User::find($notif->data['user'])->name }}</a>, your request to join <a href="{{ route('group.home', App\Group::find($notif->data['group'])) }}">{{ App\Group::find($notif->data['group'])->name }}</a> has been approved.</strong>
					@elseif($notif->type == 'App\Notifications\send_pub_invite_noti')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['sender'])) }}">{{ App\User::find($notif->data['sender'])->name }}</a> invited you to join <a href="{{ route('group.home', App\Group::find($notif->data['group'])) }}">{{ App\Group::find($notif->data['group'])->name }}.</a></strong>
					@elseif($notif->type == 'App\Notifications\send_priv_invite_noti')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['sender'])) }}">{{ App\User::find($notif->data['sender'])->name }}</a> invited you to join a private group, <a href="{{ route('group.home', App\Group::find($notif->data['group'])) }}">{{ App\Group::find($notif->data['group'])->name }}.</a></strong>
					@elseif($notif->type == 'App\Notifications\priv_group_invite_accepted')
						<strong><a href="{{ route('profile.show', App\User::find($notif->data['sender'])) }}">{{ App\User::find($notif->data['sender'])->name }}</a> accepted your invite to join the private group, <a href="{{ route('group.home', App\Group::find($notif->data['group'])) }}">{{ App\Group::find($notif->data['group'])->name }}.</a></strong>
					@endif

					@if($notif->type == 'App\Notifications\send_priv_invite_noti' && !Auth::user()->profile->member_of_groups->contains(App\Group::find($notif->data['group'])))
						<a href="{{ route('group.accept-invite-pri', $notif) }}">Accept invite</a>
					
					@else
						<?php 
							$read = ($notif->read_at != null) ? true : false; 
						?>

						@if(!$read)
						<a href="{{ route('group.noti-mar', $notif) }}">Mark as read</a>
						@else
						<a href="{{ route('group.noti-rmv', $notif) }}">Remove</a>					
						@endif

					@endif


					
				</div>
			</div>
		@empty
			No new notifications
		@endforelse
	</div>
</div>
@endsection