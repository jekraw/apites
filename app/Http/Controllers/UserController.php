<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)){
            $userDetails = UserDetail::where('id', $user->id)->first();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $userDetails,
                'message' => 'Login Successful'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password'
        ], 401);
    }
    
    // function login(request $request)
    // {
    //     $username = $request->username;
    //     $password = $request->password;

    //     $user = DB::table('user')
    //     ->where('username', $username)
    //     ->first();

    //     if ($user && Hash::check($password, $user->password)) {
    //         $userDetails = DB::table('userdetail')
    //         ->where('id', $user->id)
    //         ->first();

    //         return response()->json([
    //             'success' => true,
    //             'data' => $userDetails,
    //             'message' => 'Login Sukses'
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Username atau Password Salah!'
    //     ], 401);
    // }

    function getUser()
    {
        $user = DB::table("userdetail")
        ->get();

        return response()->json([
            'success'=>true,
            'data'=>$user,
            'message'=>'Sukses'
        ]);
    }

    function postUser(request $request)
    {
        $user = DB::table('user')
        ->insertGetId([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $detail = DB::table('userdetail')
        ->insert([
            'id' => $user,
            'nama' => $request->nama,
            'nomor' => $request->nomor,
            'email' => $request->email,
        ]);

        return response()->json([
            'success'=>true,
            'data'=>$detail,
            'message'=>'Sukses'
        ]);
    }

    function updateUser(request $request, $id)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $data2 = [
            'nama' => $request->nama,
            'nomor' => $request->nomor,
            'email' => $request->email,
        ];

        $detail = DB::table('userdetail')
        ->where('id', $id)
        ->update($data2);

        $user = DB::table('user')
        ->where('id', $id)
        ->update($data);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Sukses'
        ]);
    }

    function deleteUser($id)
    {
        $user = DB::table('user')
        ->where('id', $id)
        ->delete();

        if($user==false){
            return;
        }

        $user = DB::table('userdetail')
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success'=>true,
            'data'=>$user,
            'message'=>'Sukses'
        ]);
    }
}