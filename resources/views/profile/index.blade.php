@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mx-2">
        <h1>Profile of {{ $user->name }}</h1>
        @can('update', $user->profile)
            <strong><a href="/profile/{{$user->id}}/edit">Edit profile</a></strong>
        @endcan
    </div>
    <hr>
    
    <div class="row mt-4">
        <div class="col">
            <div class="card p-2" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                <div class="row p-2 align-items-center">
                    <div class="col">
                        <div class="mt-4" style="text-align: center;">
                            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle" width="200">
                        </div>
                        
                        <div class="mt-3 px-2">
                            <h3 class="ml-2"><b>{{ $user->name }}</b></h3>
                            <ul>
                                <li><strong>{{ $user->profile->profession }}</strong></li>
                                <li><strong>{{ $user->profile->biography }}</strong></li>
                            </ul>
                        </div>

                        <!-- follow related table -->
                        <div class="mx-3">
                            <table class="table">
                                <thead>
                                    <tr style="text-align: center;">
                                        <td>Followers</td>
                                        <td>Following</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center;">
                                        <td><a href="{{ route('profile.followerList', $user) }}">{{ $user->profile->followers->count() }}</a></td>
                                        <td><a href="{{ route('profile.followingList', $user) }}">{{ $user->following->count() }}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /follow related table -->
                        <!-- buttons -->
                        @if(Auth::id() != $user->id)
                        <div class="row mb-3">
                            <div class="col-10 offset-1">
                                @if(!auth()->user()->following->contains($user->profile))
                                <div class="mt-3">
                                    <a class="btn btn-primary btn-block" href="{{ route('follow', [$user, auth()->user()]) }}" style="text-decoration:none;">Follow</a>
                                </div>
                                @else
                                <div class="mt-3">
                                    <a class="btn btn-danger btn-block" href="{{ route('follow', [$user, auth()->user()]) }}" style="text-decoration:none;">Unfollow</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <!-- /buttons -->

                        <div class="mx-5 mb-3 mt-4 d-flex align-items-center justify-content-between">
                            @can('view', $user->profile)
                            <div>
                                <a href="{{ route('profile.likedPosts', $user) }}" data-toggle="top" title="See your liked posts">
                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-hand-thumbs-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                    </svg>
                                </a>
                            </div>
                            @endcan
                                
                            <div>
                                <a href="{{ route('profile.sharedPosts', $user) }}" data-toggle="top" title="Explore what {{ $user->name }} saved">
                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-bookmark-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5V2z"/>
                                    </svg>
                                    
                                </a>
                            </div>

                            <div>
                                <a href="{{ route('profile.member-groups', $user) }}" data-toggle="top" title="Explore {{ $user->name }}'s groups">
                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-bounding-box" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M5 2V0H0v5h2v6H0v5h5v-2h6v2h5v-5h-2V5h2V0h-5v2H5zm6 1H5v2H3v6h2v2h6v-2h2V5h-2V3zm1-2v3h3V1h-3zm3 11h-3v3h3v-3zM4 15v-3H1v3h3zM1 4h3V1H1v3z"/>
                                    </svg>
                                    
                                </a>
                            </div>                            
                        </div>
                        
                    </div> 
                </div>
            </div>
        </div>
    </div>

    @can('view', $user->profile)
    <div class="row mt-4">
        <div class="col">
            <div class="card p-4" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                <form action="/post" enctype="multipart/form-data" method="post">
                    @csrf

                    <div>
                        <h4>Share your thoughts</h4>
                    </div>

                    <div class="mt-3">
                        <input id="title" 
                               type="text" 
                               name="title"
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') ?? $user->profile->title }}" 
                               autocomplete="title" 
                               placeholder="Title" 
                               required autofocus>

                        @error('title')
                             <strong>{{ $message }}</strong>
                        @enderror
                    </div> 

                    <div class="mt-3">
                        <textarea id="content" 
                               type="text" 
                               name="content"
                               rows="6"
                               class="form-control @error('content') is-invalid @enderror" 
                               value="{{ old('content') ?? $user->profile->content }}" 
                               autocomplete="content" 
                               placeholder="Share your thoughts" required autofocus></textarea>

                        @error('profession')
                             <strong>{{ $message }}</strong>
                        @enderror
                    </div> 

                    <div class="mt-3">
                        <div>
                            <h5>Add image to post</h5>
                        </div>

                        <input type="file" name="postimage" accept="image/*" class="form-control-file" id="postimage">

                        @error('postimage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-8 offset-2">
                                <button class="btn btn-outline-primary btn-block"><strong>Create</strong></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <div class="mt-4">
        <h3>Posts</h3>
    </div>
    <hr>

    <div class="row mt-4">
        <div class="col">
            @forelse($user->posts as $post)
            <div class="card mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                <div class="card-header p-3 text-light" style="background: #52919b; border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                    <div class="d-flex justify-content-between pr-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ $post->user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
                            <a style="text-decoration: none;" href="{{ route('profile.show', $post->user) }}"><strong style="font-size: 25px; color: white; text-decoration: none;" class="mt-3 ml-3">{{ $post->user->name }}</strong></a>
                        </div>
                        <div class="d-flex align-items-center">
                            @can('update', $post->user->profile)
                                <strong><a style="color: white; text-decoration: none;" href="{{ route('post.edit', $post) }}">Edit post</a></strong>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body pl-4 pr-4 pt-4 pb-2"> 
                    <a href="{{ route('post.show', $post) }}"><h4>{{ $post->title }}</h4></a>                        
                    
                    <article>
                        <p style="font-style: italic;">
                            {{ $post->content }}
                        </p>
                    </article>

                    @if($post->postimage)
                    <div class="row">
                        <div class="col my-2 mx-1">
                            <img src="{{ '/storage/' . $post->postimage }}" class="w-100">
                        </div>
                    </div>
                    @endif 

                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <like-component pid="{{ $post->id }}" user="{{ auth()->user()->id }}" likes="{{ auth()->user()->liked_posts->contains($post->id) ?? false }}" type="{{ 'post' }}"></like-component>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div>No posts yet... make some</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
