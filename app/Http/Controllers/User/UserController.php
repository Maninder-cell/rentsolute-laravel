<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
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

    public function login(LoginRequest $request)
    {
        $token = $this->loginToken($request->email, $request->password);

        return response()->json(['token' => $token, 'data' => Auth::user()]);
    }

    public function loginToken($email, $password)
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (!$token = auth()->attempt($credentials)) {
            return ['error' => 'Credentials not found'];
        }

        return $token;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->sendResetLink();
            return response()->json(['msg' => 'We have sent you a reset email link on your email']);
        } else {
            return response()->json(['msg' => 'Email not registered']);
        }
    }

    public function getToken($token)
    {
        return auth()->parseToken($token);
    }

    public function resetPassword(Request $request, $token)
    {
        $token = $this->getToken($token);

        try {
            $payload = $token->payload();
            if ($payload) {
                if ($request->isMethod('get')) {
                    return response()->json(['msg' => 'success']);
                } else if ($request->isMethod('post')) {
                    $user = User::find($payload['sub'])->first();

                    if ($user->email == $request->email && $request->password == $request->password_confirmation) {
                        $user->forceFill([
                            'password' => Hash::make($request->password)
                        ]);

                        $user->save();

                        auth()->invalidate(); //blacklist the token
                        return response()->json(['msg' => 'Password has changed']);
                    } else {
                        return response()->json(['msg' => 'Wrong email or password and confirm password are not same']);
                    }
                }
            }
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException | \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException $e) {
            return response()->json(['error' => 'token is not valid']);
        }
    }
}
