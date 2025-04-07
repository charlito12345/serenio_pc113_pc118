<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse; 

class UserController extends Controller
{
    // public function login(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'email' => 'required|email', 
    //             'password' => 'required',
    //         ]);
    
    //         $credentials = $request->only('email', 'password');
    
    //         // Attempt to authenticate the user
    //         if (!Auth::attempt($credentials)) {
    //             return response()->json(['message' => 'Invalid credentials'], 401);
    //         }
    
    //         $user = Auth::user();
    //         $token = $user->createToken('authToken')->plainTextToken;
    
            
    //         return response()->json([
    //             'message' => 'Login successful',
    //             'user' => $user,
    //             'token' => $token,
    //         ]);
    
    //     } catch (\Exception $e) {
            
    //         return response()->json([
    //             'message' => 'An error occurred during login.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function login(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Extract credentials from the request
            $credentials = $request->only('email', 'password');

            // Attempt to authenticate the user
            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            // Return the success response
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            // Catch any exception and return a generic error response
            return response()->json([
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    

  

    public function register(Request $request): JsonResponse
    {
        try {
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,student,employee', 
            ]);

            
            $validatedData['password'] = Hash::make($validatedData['password']);

            
            $user = User::create($validatedData);

            
            $token = $user->createToken('authToken')->plainTextToken;

            
            return response()->json([
                'message' => 'User created successfully.',
                'user' => $user,
                'token' => $token,
            ], 201);
            
        } catch (ValidationException $e) {
            
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422); 
            
        } catch (QueryException $e) {
            
            return response()->json([
                'message' => 'Database error.',
                'error' => $e->getMessage(),
            ], 500); 

        } catch (\Exception $e) {
            
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

}

