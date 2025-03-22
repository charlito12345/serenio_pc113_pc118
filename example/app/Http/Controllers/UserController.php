<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (QueryException $e) {
            \Log::error('Database query error during login: ' . $e->getMessage());

            return response()->json(['message' => 'Database error occurred. Please try again later.'], 500);
        } catch (Exception $e) {
           
            \Log::error('Unexpected error during login: ' . $e->getMessage());

            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,user',
            ]);

            
            $validateData['password'] = Hash::make($validateData['password']);

            $user = User::create($validateData);

           
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (QueryException $e) {
           
            Log::error('Database query error during user creation: ' . $e->getMessage());

            return response()->json(['message' => 'Database error occurred. Please try again later.'], 500);
        } catch (Exception $e) {
            
            Log::error('Unexpected error during user creation: ' . $e->getMessage());

            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
