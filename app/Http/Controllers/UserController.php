<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;  
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function login(Request $request)
    {
        $aUser = User::isUser($request['name'],$request['password']); 
        if ($aUser[0]) {
            session(['user' => $aUser[1]]);
            return redirect()->route('board.show');
        } else {
            return redirect()->route('login.view')->with('message', $aUser[1]);
        } 
    }

    public function logout(Request $request)
    {
        session(['user' => ""]);
        return redirect()->route('login.view')->with('message', "Logout successfully!");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request['name'])) {
            $aUser = User::storeUser([
                'name' => $request['name'],
                'password' => $request['password'],
                'created_at' => Carbon::now('Asia/Taipei')
            ]); 
            if (!$aUser) {
                die("please enter another name");
            }
        } else {
            die("please enter the user name.");
        }
        return redirect()->route('login.view');
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
