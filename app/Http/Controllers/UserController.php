<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    function register(Request $request) {
        $user = new User;
        $user->firstname = $request->input('firstname');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (User::where('email', $user->email)->exists()) {
            return ['error'=>'This email is used'];
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return $user;
    }

    function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return ['error'=>'Email or Password is not matched'];
        }
        return $user;
    }
}
