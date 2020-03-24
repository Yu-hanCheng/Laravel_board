<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LaravelBord</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/mystyle.css') }}">
        <script>
        // When the user clicks on div, open the popup
            function myFunction($post_id, $comment_id) { 
                console.log($post_id, $comment_id);
                var popup = document.getElementById("myPopup");
                var input = document.createElement("input");
                    input.name = "comment_id";
                    input.type = "hidden";
                    input.value= $comment_id;
                var input2 = document.createElement("input");
                    input2.name = "post_id";
                    input2.type = "hidden";
                    input2.value= $post_id;
                popup.appendChild(input);
                popup.appendChild(input2);
                popup.classList.toggle("show");
            }
        </script>
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
                <div class="popup">
                    <form class="popuptext" action="reply" method="post" id="myPopup">
                        @csrf
                        <input type="hidden" name="type" value="1"></input>
                        <input type="text" name="content" required/>
                        <input type="submit" value="Reply">
                    </form>
                </div
                <ul style="height: 450px; overflow: auto">
                @foreach ($posts as $post)
                <li>
                    <div><a>Name</a> {{ $post['user']['name'] }} <br> <a>Created time</a> {{ substr($post->created_at, 0, strlen($post->created_at)-3) }}</div>
                    <div><a>Content</a> {{ $post->content }}</div>
                    <div>
                    <form action="like" method="post" style ="display:inline-block;">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        @if (count($post->likes) == 0)
                            <input type="hidden" name="isStore" value=1></input>
                            <input type="submit" value="Like"/>
                        @else
                            <img src="{{ asset('img/like.png') }}" width="20px" height="20px">
                            <input type="hidden" name="isStore" value=0></input>
                            <input type="submit" value="Unlike"/>
                        @endif
                    </form> <a>total {{ count($post->likesC) }} likes</a>
                    </div> 
                    
                    <form action="comment" method="post" style ="display:inline-block;">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        <input type="hidden" name="user_id" value="{{ $user_id }}"/>
                        <input type="hidden" name="type" value="0"></input>
                        <input type="text" id="content" name="content" required/>
                        <input type="submit" value="Comment">
                    </form>
                    <form action="comment" method="get" style ="display:inline-block;">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"></input>
                        <input type="submit" value="All Comments ->">
                    </form> 
                    <div>
                    <table>
                        @if (count($post['comments']) > 0)
                        <tr>
                            <th>Name</th>
                            <th>Comments</th>
                        </tr>
                        @endif
                        @foreach ($post['comments'] as $comment)
                        <tr>
                            <td>{{ $comment['user']['name'] }}</td>
                            <td>{{ $comment['content'] }}</td>
                            <td>
                                <table>
                                    @foreach ($comment['replies'] as $reply)
                                        <tr>
                                            <td>{{ $reply['user']['name'] }}</td>
                                            <td>{{ $reply['content'] }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                            <div onclick='myFunction({{ $post['id'] }}, {{ $comment['id'] }})'>Reply</div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    </div>
                </li>
                @endforeach
                </ul>
            </div>
        </div>
    </body>
</html>
