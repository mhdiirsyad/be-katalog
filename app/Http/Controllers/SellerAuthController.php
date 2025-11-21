<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerLoginRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use App\SellerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerAuthController extends Controller
{
    public function login(SellerLoginRequest $request)
    {
        $data = $request->validated();

        $identifier = $data['identifier'];

        // find by email or phone
        $seller = Seller::where('pic_email', $identifier)
            ->orWhere('pic_phone', $identifier)
            ->first();

        if (!$seller || !Hash::check($data['password'], $seller->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // allow login only for approved sellers
        if ($seller->status !== SellerStatus::ACTIVE->name) {
            return response()->json(['message' => 'Account not approved'], 403);
        }

        $device = $data['device_name'] ?? 'api-client';
        $token = $seller->createToken($device)->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => new SellerResource($seller),
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        /** @var Seller $seller */
        $seller = $request->user();
        if ($seller) {
            // revoke current access token
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logged out'], 200);
    }
}
