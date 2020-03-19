<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LaravelBoard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/mystyle.css') }}">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Login
                </div>
                @if (session('message'))
                <div>{{ session('message') }}</div>
                @endif
                <form action="login" method="post">
                    @csrf
                    <input type="text" id="name" name="name"/>
                    <input type="text" id="password" name="password"/>
                    <input type="submit" value="Login">
                </form> 
            </div>
        </div>
    </body>
</html>
