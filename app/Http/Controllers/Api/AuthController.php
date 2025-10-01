<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Generate API token for authenticated user
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255'
        ]);

        $token = $request->user()->createToken($request->token_name);

        return response()->json([
            'success' => true,
            'message' => 'Token generated successfully',
            'token' => $token->plainTextToken,
            'token_name' => $request->token_name
        ], 201);
    }

    /**
     * Revoke user's tokens
     */
    public function revokeTokens(Request $request)
    {
       
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'All tokens revoked successfully'
        ], 200);
    }

    /**
     * List user's active tokens
     */
    public function listTokens(Request $request)
    {
        $tokens = $request->user()->tokens()->get(['id', 'name', 'created_at', 'last_used_at']);

        return response()->json([
            'success' => true,
            'data' => $tokens
        ], 200);
    }

    /**
     * Login and generate token (alternative method)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token_name' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->token_name);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ], 200);
    }

    /**
     * Logout (revoke current token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}