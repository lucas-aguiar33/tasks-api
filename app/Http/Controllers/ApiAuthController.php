<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidationRequest;
use App\Http\Requests\RegisterValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;

class ApiAuthController extends Controller
{
    public function register (RegisterValidationRequest $request)
    {
        
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return (new UserResource($user))->additional([
            'success' => true,
            'token' => $token
        ])->response()->setStatusCode(201);
    }


    public function login(LoginValidationRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciais inválidas',
            ], 401);
        }   

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return (new UserResource($user))->additional([
            'success'=>true,
            'token' => $token
        ])->response()->setStatusCode(200);
    }


    public function logout(Request $request) 
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();

    }

}
