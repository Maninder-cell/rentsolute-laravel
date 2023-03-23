<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $token = $this->loginToken($request->email, $request->password);

        return response()->json(['token' => $token, 'data' => $user]);
    }

    public function login(LoginRequest $request){
        $token = $this->loginToken($request->email,$request->password);

        return response()->json(['token' => $token, 'data' => Auth::user()]);
    }

    public function loginToken($email, $password)
    {
        $credentials = ['email' => $email,'password' => $password];

        if (! $token = auth()->attempt($credentials)) {
            return ['error' => 'Credentials not found'];
        }

        return $token;
    }
}
