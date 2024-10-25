<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller {
    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'about_me' => 'nullable|string',
        'profile_image' => 'nullable|string',
        'website_link' => 'nullable|url',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'about_me' => $validatedData['about_me'],
        'profile_image' => $validatedData['profile_image'],
        'website_link' => $validatedData['website_link'],
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}


public function login(Request $request)
{
    
     
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        
    ]);
    
    Log::info('Login attempt', $credentials);

    if (!Auth::attempt($credentials)) {
        Log::warning('Login failed for credentials: ', $credentials);
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    
    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ], 200);
}



    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
