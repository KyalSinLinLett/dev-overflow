<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'd3v-overfl0w') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'd3v-overfl0w') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <?php $user = auth()->user(); ?>
                            <li class="nav-item dropdown"> 
                                <!-- Dropdown -->
                                  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Groups 
                                    @if(Auth::user()->unreadNotifications()->where('type', "App\Notifications\join_request_approved")->get()->count() > 0 || Auth::user()->unreadNotifications()->where('type', "App\Notifications\send_pub_invite_noti")->get()->count() > 0 || Auth::user()->unreadNotifications()->where('type', "App\Notifications\send_priv_invite_noti")->get()->count() > 0 || Auth::user()->unreadNotifications()->where('type', "App\Notifications\priv_group_invite_accepted")->get()->count() > 0)
                                        <small class="text-light px-2" style="background-color: red; border-radius: 50%;">
                                        </small>
                                    @endif
                                  </a>
                                  <div class="dropdown-menu">

                                    <a class="dropdown-item" href="{{ route('group.index') }}">Groups I'm admin</a>

                                    <a class="dropdown-item" href="{{ route('group.joined') }}">Groups I've joined</a>

                                    <a class="dropdown-item" href="{{ route('group.noti') }}">Groups notifications: <small class="text-light px-2 py-1" style="background-color: red; border-radius: 50%;"><strong>{{ Auth::user()->unreadNotifications()->where('type', "App\Notifications\join_request_approved")->get()->count() + Auth::user()->unreadNotifications()->where('type', "App\Notifications\send_pub_invite_noti")->get()->count() + Auth::user()->unreadNotifications()->where('type', "App\Notifications\send_priv_invite_noti")->get()->count() + Auth::user()->unreadNotifications()->where('type', "App\Notifications\priv_group_invite_accepted")->get()->count() }}</strong></small></a>
                                  
                                  </div>
                                </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('post.privatefeed') }}">My Circle</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.show', $user) }}">My Profile</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="mt-3">
            @yield('content')
        </main>
    </div>
</body>
</html>
