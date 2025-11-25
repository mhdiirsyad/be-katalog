<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari Admin berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Cek Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // 4. Buat Token
        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login Admin berhasil',
            'data' => $user,
            'token' => $token, // Token ini dipakai di Postman/FE
        ], 200);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Admin berhasil logout'], 200);
    }
}