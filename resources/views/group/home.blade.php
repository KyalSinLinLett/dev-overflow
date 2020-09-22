@extends('layouts.app')

@section('content')
<div class="container">

		@if(session()->has('success'))
			<div id="message_id" class="card px-4 py-4 bg-success text-light">
				{{ session()->get('success') }}
			</div>
		@endif
		@if(session()->has('error'))
			<div id="message_id" class="card px-4 py-4 bg-danger text-light">
				{{ session()->get('error') }}
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
	            <div class="card p-2 mb-3" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
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
 	                                <li><strong>Member count: {{ $group->member->count() }}</strong></li>
	                            </ul>

	                            <div>
	                            	@if(!$group->privacy && !$group->admin->contains(Auth::user()->profile) && !$group->member->contains(Auth::user()->profile))
	                            		
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
	                        			@if(!$group->privacy)
	                        				<strong>Welcome back, {{ Auth::user()->name }}!</strong>
	                        				<a href="{{ route('group.invite-public', $group) }}">Invite your friends</a>	
	                        			@endif

	                            	@endif
	                            </div>
	                        </div>
	                    </div> 
	                </div>
	            </div>
		@if(!$group->privacy || $group->admin->contains(Auth::user()->profile) || $group->member->contains(Auth::user()->profile))
            <div class="card" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
            	<div class="card-header bg-dark text-light" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
            		<h3 class="mt-2">Share something to the group</h3>
            	</div>	
            	<div class="card-body">
            		<form action="{{ route('group.create-post') }}" method="post" class="form-group" enctype="multipart/form-data">
            			@csrf
            			<input type="hidden" name="group_id" value="{{ $group->id }}">
            			<textarea name="content" class="form-control mb-3" cols="50" rows="5" placeholder="Share something..." required></textarea> 
            			<label for="img">Share images to your group</label>
            			<input id="img"
            				   type="file" 
            				   accept="image/*"
            				   name="attachment[]" 
            				   class="form control mb-3" 
            				   multiple>
            			<div class="mb-3">
							<a href="{{ route('group.upload-docfiles', $group) }}">Share other files to the group</a>            				
            			</div>
            			<input type="submit" name="submit" class="btn btn-info form-control" value="Post">
            		</form>
            	</div>
            </div>
            <hr>

            <h2>
            	Group posts
            </h2>
            <hr>

            @forelse($group->group_posts as $gp)
            <div class="card mb-3" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
        		<div class="card-header p-3 bg-dark text-light" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
        			<div class="d-flex justify-content-between pr-2">
        				<div class="d-flex align-items-center">
        					<a href="{{ route('profile.show', $gp->user_id) }}"><img  class="mr-3" src="{{ App\User::find($gp->user_id)->profile->profileImage() }}" width="50" height="50" style="border-radius: 50%;"></a>
        					<strong>
        						<a style="text-decoration: none; color: white;" href="{{ route('profile.show', $gp->user_id) }}"><strong>{{ App\User::find($gp->user_id)->name }}</strong></a> posted {{ $gp->created_at->diffForHumans() }}
        					</strong>
        				</div>
        				@if($gp->user_id == Auth::id())
        				<div class="d-flex align-items-center">
        					@if($gp->attachment != null)
        					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Edit post</a> &nbsp|&nbsp
        					@elseif($gp->files != null)        					
        					<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Edit post</a> &nbsp|&nbsp
        					@else
        						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-img', $gp) }}">Add images</a> &nbsp|&nbsp
        						<a style="text-decoration: none; color: white;" href="{{ route('group.groupPost-edit-doc', $gp) }}">Add files</a> &nbsp|&nbsp
        					@endif
        					<a style="text-decoration: none; color: red;" onclick="return confirm('Do you want to delete this post?')" href="{{ route('group.groupPost-delete', $gp) }}">Delete</a>
        				</div>
        				@endif
        			</div>
        		</div>
        		<div class="card-body pl-4 pr-4 pt-4 pb-2"> 
        			<a style="text-decoration: none; color: black;" href="{{ route('group.view-post', $gp) }}"><p class="pl-3 mt-3"><strong>{{ $gp->content }}</strong></p></a>
          			@if($gp->attachment != null)
          				@if(sizeof(json_decode($gp->attachment, $assoc=true)) > 1 )
            			<div id="carouselExampleControlsOri" class="carousel slide p-2" data-ride="carousel">
            			  <div class="carousel-inner">
            			  	<div class="carousel-item active">
            			  	  <img class="d-block w-100" src="{{ '/storage/' . json_decode($gp->attachment, $assoc=true)[0] }}">
            			  	</div>
            			    @foreach(json_decode($gp->attachment) as $att)
            				    @if($att != json_decode($gp->attachment, $assoc=true)[0])
            				    <div class="carousel-item">
            				      <img class="d-block w-100" src="{{ '/storage/' . $att }}">
            				    </div>
            				    @endif
            			    @endforeach
            			  </div>
            			  <a class="carousel-control-prev" href="#carouselExampleControlsOri" role="button" data-slide="prev">
            			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            			    <span class="sr-only">Previous</span>
            			  </a>
            			  <a class="carousel-control-next" href="#carouselExampleControlsOri" role="button" data-slide="next">
            			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
            			    <span class="sr-only">Next</span>
            			  </a>
            			</div>
            			@else
            				<div>
            					<img class="d-block w-100" src="{{ '/storage/' . json_decode($gp->attachment, $assoc=true)[0] }}">
            				</div>
            			@endif
      				@elseif($gp->files != null)
			  			@foreach(json_decode($gp->files) as $file)
				  			<div class="ml-3">
				  				<?php
				  					$file_name = explode('@', $file)[1];
				  				?>
				  				<p><b>#</b> <a onclick="return confirm('Do you want to download this file?')" href="{{ '/group/file-download/' . $file }}"><strong>{{ $file_name }}</strong></a></p>
				  			</div>
						@endforeach
      				@endif

                    <div class="d-flex ml-3 mb-3 mt-2">
                        Likes: {{ $gp->liked_by->count() }}
                        Comments: {{ $gp->gp_comments->count() }}
                    </div>

            	</div>
            </div>
            @empty
            	<div class="my-5">There are no posts yet...</div>
            @endforelse
            	
            
	    @else
	    	<div>
	    		This is a private group. You must be invited by the admins to become a member.
	    	</div>
	    @endif
	        </div>
	    </div>
	
</div>
@endsection('content')