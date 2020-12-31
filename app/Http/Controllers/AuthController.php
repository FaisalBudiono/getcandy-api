<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email:filter'],
            'password' => ['required', 'string']
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            return $this->responseEmailOrPasswordInvalid();
        }

        if (! Hash::check($password, $user->password)) {
            return $this->responseEmailOrPasswordInvalid();
        }

        auth()->setUser($user);

        return response()->json([
            'token' => $user->createToken('admin-hub')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (is_null($user)) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logout succesfully'
        ], Response::HTTP_OK);
    }

    protected function responseEmailOrPasswordInvalid()
    {
        return response()->json([
            'message' => 'Email or Password is invalid.'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
