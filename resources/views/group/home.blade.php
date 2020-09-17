@extends('layouts.app')

@section('content')
<div class="container">

		@if(session()->has('success'))
			<div class="card px-4 py-4 bg-success text-light">
				{{ session()->get('success') }}
			</div>
		@endif

	    <div class="d-flex justify-content-between align-items-center mx-2">
	        <h1>{{ $group->name }}'s home</h1>
	        @if($group->admin->contains(Auth::user()->profile))
	        <a href="{{ route('group.post-panel', $group) }}">
	        	@if( $group->unreadNotifications()->get()->count() > 0 )
					<small class="text-light px-1" style="background-color: red; border-radius: 50%;"><strong>{{ $group->unreadNotifications()->get()->count() }}</strong></small>
				@endif 

				Enter admin panel
			</a>	
	        @endif    
	    </div>
	    <hr>
	    
	    <div class="row mt-4">
	        <div class="col">
	            <div class="card p-2" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
	                <div class="row p-2 align-items-center">
	                    <div class="col">
	                        <div class="mt-4" style="text-align: center;">
	                            <img src="{{ $group->groupImage() }}" class="rounded-circle" width="200">
	                        </div>
	                        
	                        <div class="mt-3 px-2">
	                        	<div class="align-items-center d-flex">
	                        		<h3 class="ml-4 mr-3"><b>{{ $group->name }}</b></h3>
	                        		@if($group->admin->contains(Auth::user()->profile))
	                        		<a href="{{ route('group.edit', $group) }}">Edit details</a>	
	                        		@endif      	
	                        	</div>
	                            <ul>
	                                <li><strong>{{ $group->category }}</strong></li>
	                                <li><strong>{{ $group->description }}</strong></li>
	                                <li><strong>Created: {{ $group->created_at->diffForHumans() }}</strong></li>
	                                <li><strong>Admin(s): 
	                                	@foreach($group->admin as $admin)
	                                	{{ App\User::find($admin->user_id)->name }} | 
	                                	@endforeach
 	                                </strong></li>
	                            </ul>

	                            <div>
	                            	@if(!$group->admin->contains(Auth::user()->profile) && !$group->member->contains(Auth::user()->profile))
	                            		
										<?php

										$sent = (DB::table('group_notification_flag')->where([['group_id', '=', $group->id], ['user_id', '=', Auth::id()]])->value('sent')) ? true : false;

										?>

										<?php $user = Auth::user(); ?>   										
	                            		@if(!$sent)	  
	                            			<a href="{{ route('group.join-notif', [$user, $group]) }}">Send join request</a>
	                        			@else
	                        				<a href="{{ route('group.cancel-request', [$user, $group]) }}">cancel request</a>
	                        				<small>Your request will be reviewed by the admins shortly...</small>
	                        			@endif
	                        		@else
	                        			<strong>Welcome back, {{ Auth::user()->name }}!</strong>

	                        			@if(!$group->privacy)
	                        				<a href="{{ route('group.invite-public', $group) }}">Invite your friends</a>	
	                        			@endif












	                            	@endif
	                            </div>
	                        </div>
	                    </div> 
	                </div>
	            </div>
	        </div>
	    </div>

</div>
@endsection('content')