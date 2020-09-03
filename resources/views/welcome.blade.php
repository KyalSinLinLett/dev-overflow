@extends('layouts.app')

@section('content')
<div class="container">
    @if (Route::has('login'))
        <div>
            @auth
                @include('newsfeed')            
            @else
                <div>
                    <h2>Welcome to d3v-overfl0w</h2>
                    <p>
                        d3v-overfl0w is a simplistic social network for those that are tired of mainstream social media with their algorithmic bias and targeted ads.
                    </p>
                </div>
                
                <div>
                    <strong>Already a member? <a href="{{ route('login') }}">Login</a></strong>
                </div>

                <div>
                    @if (Route::has('register'))
                        <strong>New to d3v-overfl0w? <a href="{{ route('register') }}">Register</a></strong>
                    @endif
                </div>
            @endauth
        </div>
    @endif
</div>
@endsection