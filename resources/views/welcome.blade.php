<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LaravelBord</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/mystyle.css') }}">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login.view') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register.view') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                @if (session('user_id'))
                <div class="title m-b-md">Hi, {{ session('user_name') }}</div>
                <div class="row">
                <form action="post" method="post">
                    @csrf
                    <a>What's new?</a>
                    <input type="text" id="content" name="content"/>
                    <input type="hidden" name="user_id" value="{{ session('user_id') }}"/>
                    <input type="hidden" name="user_name" value="{{ session('user_name') }}"/>
                    <input type="submit" value="Post">
                </form>
                </div>
                @else
                <div class="title m-b-md">Laravel Board</div>
                @endif
            </div>
        </div>
    </body>
</html>
