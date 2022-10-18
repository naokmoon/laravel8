<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ mix('js/app.js')}}" defer></script>
    <title>{{ config('app.name', 'LaravelApp') }} - @yield('title')</title>
</head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto">
            <a href="{{ route('home.index') }}" style="color:black;">
                {{ config('app.name', 'LaravelApp') }}
            </a>
        </h5>
        <nav class="mt-2 mt-md-0 mr-md-3">
            <!-- Authentication Links -->
            @guest
                {{-- Not Logged --}}
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                {{-- Logged In --}}
                    <a class="p-2 text-dark" href="{{ route('home.index') }}">Home</a>
                    <a class="p-2 text-dark" href="{{ route('home.contact') }}">Contact</a>
                    <a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>

                    <a id="navbarDropdown" class="nav-link dropdown-toggle float" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endguest


        </nav>
    </div>
    <div class="container py-3">
        @if(session('status'))
            <div class="alert alert-success mb-2" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
