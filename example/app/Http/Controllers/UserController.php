<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
{
  $request->validate([
'email'=>'required email', 
'password'=>'required',

  ]);

  $credentials =$request->only('email','password');

  if (!Auth::attempt($credentials)) {
    return response()->json(['message'=>'Invalid cregdential'],401);
  }
  $user = Auth::user();
  $token = $user->createToken('authToken')->plaintextToken;
  return response()->json([
    'message' => 'login successful',
    'user' => $user,
    'token' => $token,
  ]);
}

  public function create(Request $request)
  {
     $validateData =$request->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'role' => 'required in:admin,user',
     ]);
    
    
    
    
    $validateData['password'] = Hash::make($validateData['password']);

    $user =User::create($validateData);

    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'message' => 'user created successfully',
        'user' => $user,
        'tokin' => $token,
    ],201);
}

}

