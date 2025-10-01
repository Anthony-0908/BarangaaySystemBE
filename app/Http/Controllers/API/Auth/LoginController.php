<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
  public function login(Request $request)
{
    // 1. Validate Input
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }
    
    // 2. Find User and Check Password (Manual Authentication)
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }
    
    // 3. Generate Token (Successful Token Login)
    // Revokes all existing tokens for security
    $user->tokens()->delete(); 

    // Create a new token
    $token = $user->createToken('auth_tokens')->plainTextToken;

    
    // 4. Return Response
    return response()->json([
        'message' => 'Login successful',
        'user' => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            // ⚠️ Make sure $user->getRoleNames() exists OR remove this line
            'roles' => $user->getRoleNames(), 
        ],
        'token' => $token,
        'token_type' => 'Bearer',
    ]);
}


//     public function login(Request $request)
// {
//     $request->validate([
//         'email'    => 'required|email',
//         'password' => 'required|string|min:6',
//     ]);

//     if (!Auth::attempt($request->only('email', 'password'))) {
//         return response()->json([
//             'message' => 'Invalid credentials'
//         ], 401);
//     }

//     $user = Auth::user();

//    return response()->json([
//     'message' => 'Login successful',
//     'user' => [
//         'id' => $user->id,
//         'name' => $user->name,
//         'email' => $user->email,
//         'roles' => $user->getRoleNames(),
//     ],
//     'token' => $token, // <- send token
// ]);
// }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
