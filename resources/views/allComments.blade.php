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
            function myFunction($comment_id) { 
                var popup = document.getElementById("myPopup");
                var input = document.createElement("input");
                    input.name = "comment_id";
                    input.type = "hidden";
                    input.value= $comment_id;
                popup.appendChild(input);
                popup.classList.toggle("show");
            }
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                        <a href="{{ route('board.show') }}">Home</a>
                        <a href="{{ route('logout') }}">Logout</a>
                </div>
            @endif
            <div class="content">
                <div class="popup">
                    <form class="popuptext" action="reply" method="post" id="myPopup">
                        @csrf
                        <input type="hidden" name="type" value="1"></input>
                        <input type="hidden" name="post_id" value="{{ $response['post']['id'] }}"></input>
                        <input type="text" name="content" required/>
                        <input type="submit" value="Reply">
                    </form>
                </div>
               <table>
                    <tr>
                        <th>Post</th>
                    </tr>
                    <tr><td>{{ $response['post']['content'] }}</td></tr>
                    <tr><td><b>Who likes:</b> 
                        @foreach ($response['likes'] as $user)
                               <a>{{ $user['name'].', ' }}</a>
                                
                        @endforeach
                    </td></tr>
                    <tr>
                        <form action="comment" method="post">
                            @csrf
                            <a>Comment...</a>
                            <input type="hidden" name="post_id" value="{{ $response['post']['id'] }}"></input>
                            <input type="hidden" name="type" value="0"/>>
                            <input type="text" id="comment_content" name="content" required/>> 
                            <input type="submit" value="Comment">
                        </form>
                    </tr>
               </table> 
                <div class="row">
                <table >
                    <tr>
                        <th>Name</th>
                        <th>Comments</th>
                    </tr>
                    @foreach ($response['Allcomments'] as $comment)
                    <tr>
                        <td>{{ $comment['user_name'] }}</td>
                        <td>{{ $comment['content'] }}</td>
                        <td>
                            <table>
                                @foreach ($comment['reply'] as $reply)
                                    <tr>
                                        <td>{{ $reply['user_name'] }}</td>
                                        <td>{{ $reply['content'] }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>
                        <div onclick='myFunction({{ $comment['id'] }})'>Reply</div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </body>
</html>
