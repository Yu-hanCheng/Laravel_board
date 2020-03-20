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
                        <a href="{{ route('logout') }}">Logout</a>
                    @endauth
                </div>
            @endif
            <div class="content">
                
                @if ( $user_id )
                <div class="title m-b-md">Hi, {{ $user_name }}</div>
                <div class="row">
                <form action="post" method="post">
                    @csrf
                    <a>What's new?</a>
                    <input type="text" id="content" name="content"/>
                    <input type="hidden" name="user_id" value="{{ $user_id }}"/>
                    <input type="hidden" name="user_name" value="{{ $user_name }}"/>
                    <input type="submit" value="Post">
                </form>
                </div>
                @else
                <div class="title m-b-md">Laravel Board</div>
                @endif
                <ul style="height: 450px; overflow: auto">
                @foreach ($posts as $post)
                <li>
                    <div><a>Name</a> {{ $post->user_name }}</div>
                    <div><a>Created time</a> {{ substr($post->created_at, 0, strlen($post->created_at)-3) }}</div>
                    <div><a>Content</a> {{ $post->content }}</div>
                    <form action="like" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        @if (!$post->like)
                            <input type="hidden" name="isStore" value=1></input>
                            <input type="submit" value="Like"/>
                        @else
                            <img src="{{ asset('img/like.png') }}" width="20px" height="20px">
                            <input type="hidden" name="isStore" value=0></input>
                            <input type="submit" value="Unlike"/>
                        @endif
                    </form> 
                    <form action="comment" method="get">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        <input type="submit" value="All Comments -->">
                    </form> 
                    <form action="comment" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        <input type="hidden" name="type" value="0"></input>
                        <input type="text" id="content" name="content" required><br><br>
                        <input type="submit" value="Comment">
                    </form>
                </li>
                @endforeach
                </ul>
            </div>
        </div>
    </body>
</html>
