<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    public function store(SellerStoreRequest $request) {
        $data = $request->validated();
        try {
            // handle uploaded files
            if ($request->hasFile('pic_photo_path')) {
                $data['pic_photo_path'] = $request->file('pic_photo_path')->store('seller_photos', 'public');
            }
            if ($request->hasFile('pic_ktp_file_path')) {
                $data['pic_ktp_file_path'] = $request->file('pic_ktp_file_path')->store('seller_ktp', 'public');
            }

            // ensure password is hashed
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            Log::info('SellerController::store - payload', ['payload' => $data]);

            $seller = Seller::register($data);
            Log::info('SellerController::store - create result', ['seller' => $seller?->toArray()]);

            if(!$seller) {
                Log::error('SellerController::store - create returned falsy', ['payload' => $data]);
                return response()->json([
                    'message' => 'Gagal membuat seller',
                ], 500);
            }

            return response()->json([
                'message' => 'Seller berhasil dibuat',
                'data' => new SellerResource($seller),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat seller',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $seller = Seller::find($id);
            if(!$seller) {
                return response()->json([
                    'message' => 'Seller tidak ditemukan',
                    'data' => null
                ], 404);
            };
            return response()->json([
                'message' => 'Seller ditemukan',
                'data' => new SellerResource($seller),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data seller',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index() {
        try {
            $sellers = Seller::get();
            if($sellers->isEmpty()) {
                return response()->json([
                    'message' => 'No sellers found',
                    'data' => []
                ], 200);
            };
            return response()->json([
                'message' => 'Sellers retrieved successfully',
                'data' => SellerResource::collection($sellers),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve sellers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
