<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>d3v-overfl0w</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    </head>
    <body>
        <div class="container mt-5">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <div class="mt-5">
                            <strong>Go to your profile <a href="{{ route('profile.show', Auth::id()) }}">Profile</a></strong>
                        </div>
                        
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
    </body>
</html>
