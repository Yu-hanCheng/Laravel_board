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
                        <a href="{{ route('board.show') }}">Home</a>
                        <a href="{{ route('logout') }}">Logout</a>
                </div>
            @endif
            <div class="content">
               <table>
                    <tr>
                        <th>Post</th>
                    </tr>
                    <tr><td><?= $response['post']['content']; ?></td></tr>
                    <tr>
                        <form action="comment" method="post">
                            @csrf
                            <a>Comment...</a>
                            <input type="hidden" name="post_id" value="<?= $response['post']['id']; ?>"></input>
                            <input type="hidden" name="type" value="0"/>>
                            <input type="text" id="content" name="content"/>> 
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
                    <?php foreach ($response['Allcomments'] as $comment) : ?>
                    <tr>
                        <td><?= $comment['user_name'] ?></td>
                        <td><?= $comment['content'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                            </table>
            </div>
        </div>
    </body>
</html>
