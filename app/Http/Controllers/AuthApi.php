<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthApi extends Controller
{
    public function register()
    {
        $v = Validator::make(request()->all(), [
            'name' => 'required|min:3',
            'email' => 'required|min:3',
            'password' => 'required|min:3',
            'image' => 'mimes:jpg,png,jpeg',

        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }

        $name = request()->name;
        $email = request()->email;
        $password = request()->password;
        $image = request()->image;

        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move('image', $image_name);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $token = $user->createToken('APPLICATION')->accessToken;
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $user,
            'token' => $token,
        ]);
    }

    public function login()
    {

        $v = Validator::make(request()->all(), [

            'email' => 'required|min:3',
            'password' => 'required|min:3',

        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }
        $email = request()->email;
        $password = request()->password;
        $creat = ['email' => $email, 'password' => $password];

        if (Auth::attempt($creat)) {
            $user = Auth::user();
            $token = $user->createToken('APPLICATION')->accessToken;
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $user,
                'taken' => $token,

            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => 'fail',
            'data' => [
                'error' => 'email and password incorrect',
            ],
        ]);
    }

}
