<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Helper function agar format response konsisten (DRY Principle)
    private function jsonResponse($status, $message, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // butuh field password_confirmation
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse('error', 'Validation Error', $validator->errors(), 422);
        }

        // 2. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Return JSON Success
        return $this->jsonResponse('success', 'User registered successfully', $user, 201);
    }

    public function login(Request $request)
    {
        // 1. Validasi dasar input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse('error', 'Validation Error', $validator->errors(), 422);
        }

        // 2. Cek Kredensial (User Enumeration Protection)
        // Kita pakai pesan error generic agar hacker tidak tahu apakah emailnya yang salah atau passwordnya.
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->jsonResponse('error', 'Email atau password salah', null, 401);
        }

        // 3. Jika sukses, Generate Token Sanctum
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Return Token & Data User
        return $this->jsonResponse('success', 'Login successful', [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan saat ini (Current Access Token)
        $request->user()->currentAccessToken()->delete();

        return $this->jsonResponse('success', 'Logout successful', null, 200);
    }

    public function profile(Request $request)
    {
        // Mengambil data user dari token yang valid
        return $this->jsonResponse('success', 'User profile fetched', $request->user(), 200);
    }
}