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
//        SOJ: 沒有 validator

//        SOJ: 更優雅的寫法
//        try {
//            $user = User::check($request['name'], $request['password']);
//            $token = Str::random(80);
//            $user->update([
//                'api_token' => hash('sha256', $token),
//            ]);
//
//            return response(["msg" => $token], 200);
//        } catch (\Exception $e) {
//            return response(['msg' => $e->getMessage()], 400);
//        }
//
        $aUser = User::isUser($request['name'], $request['password']);
        if ($aUser[0]) {
//            SOJ: 為何使用 session?
            session(['user' => $aUser[1]->name]);
            $token = Str::random(80);
            $aUser[1]->forceFill([
                'api_token' => hash('sha256', $token),
                ])->save();
            return response()->json(["msg" => $token], 200);
        } else {
            return response()->json(["msg" => $aUser[1]], 400);
        } 
    }

    public function logout(Request $request)
    {
//        SOJ: 沒有 validator

//        SOJ: 何不直接更新成 null 就好
//        $userName = $request->user()->name;
//        $request->user()->update([
//            'api_token' => null,
//        ]);
//
//        return response(['msg' => $userName . ' is logout'], 200);
//
//
        $user = User::find($request->user()->id);
        $token = Str::random(80);
        $user->forceFill([
            'api_token' => hash('sha256', $token),
            ])->save();
        return response()->json(["msg" => "successfully"], 200);
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
            'name' => 'required|unique:users|',
            'password' =>'required',
        ]);
        
        if ($va->fails()) {
//            SOJ: error code 不應該使用 416
//            SOJ: 可以直接在 response() 裡面放 array 不用另外寫 json()
            return response()->json(['msg' => (string)$va->errors()], 416);
        }
        $token = Str::random(80);
        $user = User::create([
            'name'     => $request['name'],
//                        SOJ: 可以 $request 可以當 object 取值
//            'name'     => $request->name,
            'password' => Hash::make($request['password']),
            ]);
        $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
//        SOJ: 為何不把 api_token 加入 model 裡的 fillable，然後使用 update 的方法
//        $user->update([
//            'api_token' => $token,
//        ]);
        return response()->json(["msg" => $token], 201);
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
