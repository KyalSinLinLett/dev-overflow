@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-baseline mx-3 row border-bottom">
        <h2>Profile of {{ $user->name }}</h2>

        @can('update', $user->profile)
            <strong><a href="/profile/{{$user->id}}/edit">Edit profile</a></strong>
        @endcan
    </div>
    
    <div class="row mt-4">
        <div class="col">
            <div class="card p-2" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                <div class="row p-2 align-items-center">
                    <div class="col">
                        <div class="mt-4" style="text-align: center;">
                            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle" width="200">
                        </div>
                        
                        <div class="mt-3 px-2">
                            <h3 class="ml-4"><b>{{ $user->name }}</b></h3>
                            <ul>
                                <li><strong>{{ $user->profile->profession }}</strong></li>
                                <li><strong>{{ $user->profile->biography }}</strong></li>
                            </ul>
                        </div>

                        <!-- follow related table -->
                        <div class="mx-4">
                            <table class="table">
                                <thead>
                                    <tr style="text-align: center;">
                                        <td>Followers</td>
                                        <td>Following</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center;">
                                        <td>{{ $user->profile->followers->count() }}</td>
                                        <td>{{ $user->following->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /follow related table -->
                        <!-- buttons -->
                        <div class="row mb-3">
                            <div class="col-10 offset-1">
                                @if(Auth::id() != $user->id)
                                <div class="d-flex"> 
                                     <follow-component id="{{ $user->id }}" follows="{{ $follows }}"></follow-component>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- /buttons -->
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

                        <input type="file" name="postimage" class="form-control-file" id="postimage">

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

    <div class="row mt-4">
        <div class="col">
            @if($user->posts)
            @foreach($user->posts as $post)
            <div class="card p-4 mb-3"style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">

                <div class="row">
                    <div class="col d-flex">
                        <img src="{{ $user->profile->profileImage() }}" class="rounded-circle" width="50" height="50">
                        <h4 class="mt-3 ml-3" >
                            <strong>{{ $user->name }}</strong>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mt-3">
                            <h4>{{ $post->title }}</h4>                    
                        </div>
                        <div>
                            <article>
                                <i>
                                    {{ $post->content }}
                                </i>
                            </article>

                            @if($post->postimage)
                            <div class="row">
                                <div class="col my-4 mx-1">
                                    <img src="{{ '/storage/' . $post->postimage }}" class="w-100">
                                </div>
                            </div>
                            @endif 

                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

</div>
@endsection
