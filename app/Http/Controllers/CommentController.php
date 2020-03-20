<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Carbon\Carbon;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = "";
        try {
            $response = json_decode(json_encode(Comment::showComments($_GET['post_id'])),true);
        } catch (\Throwable  $e) {
            echo $e->getMessage();
        }
        return view('allComments',['response' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Comment::storeComment([
            'post_id' => $request['post_id'],
            'user_id' => session('user')['id'],
            'name' => session('user')['name'],
            'content' => $request['content'],
            'created_at' => Carbon::now('Asia/Taipei'),
        ]);
        return redirect()->route('comment.show',['post_id' => $request['post_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
