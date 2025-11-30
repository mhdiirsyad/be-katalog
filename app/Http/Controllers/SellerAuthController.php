<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerLoginRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // Tambahkan ini

class SellerAuthController extends Controller
{
    public function login(SellerLoginRequest $request)
    {
        $data = $request->validated();
        $identifier = $data['identifier'];

        $seller = Seller::where('email_pic', $identifier)
            ->orWhere('no_hp_pic', $identifier)
            ->first();

        if (!$seller || !Hash::check($data['password'], $seller->password)) {
            // Mengembalikan error validation standard agar bisa ditangkap frontend dengan mudah
            throw ValidationException::withMessages([
                'identifier' => ['Kredensial yang diberikan salah.'],
            ]);
        }

        // Generate Token
        $device = $data['device_name'] ?? 'nuxt-client';
        $token = $seller->createToken($device)->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => new SellerResource($seller), // Data user yang sudah diformat Resource
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}