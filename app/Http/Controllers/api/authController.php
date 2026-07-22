<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 422);
        }

        $user = User::where('name', $request->user_name)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or ppppassword',
            ], 401);
        }

        if ($user->status == 'Inactive') {
            return response()->json([
                'status' => 'error',
                'message' => 'Account is inactive',
            ], 403);
        }

        $token = $user->createToken($request->user_name);

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'message' => 'Logged in successfully',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        try {
            // Delete all tokens for the authenticated user
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
