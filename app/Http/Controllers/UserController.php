<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    function login(request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = DB::table('user')
        ->where('username', $username)
        ->first();

        if ($user && Hash::check($password, $user->password)) {
            $userDetails = DB::table('userdetail')
            ->where('id', $user->id)
            ->first();

            return response()->json([
                'success' => true,
                'data' => $userDetails,
                'message' => 'Login Sukses'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Username atau Password Salah!'
        ], 401);
    }

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