<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;  
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
        try {
            $user = User::check($request['name'], $request['password']); 
            $token = Str::random(80);
            $user->update(['api_token' => hash('sha256', $token)]);
            return response(['message' => $token], 200);
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->update(['api_token' => NULL]);
        return response(["message" => $request->user()->id . " is logout"], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $va = Validator::make($request->all(), [
            'name' => 'required|max:20|unique:users|',
            'password' =>'required',
        ]);
        
        if($va->errors()->has('name')){
            return response(['message' => $va->errors()->messages()['name'][0]], 400);
        };
        if($va->errors()->has('password')){
            return response(['message' => $va->errors()->messages()['password'][0]], 400);
        };
        $token = Str::random(80);
        User::create([
                'name' => $request['name'],
                'password' => Hash::make($request['password']),
                'api_token' => hash('sha256', $token),
            ]);
        return response(["message" => $token], 201);
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
