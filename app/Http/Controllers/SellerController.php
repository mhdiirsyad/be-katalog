<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;

class SellerController extends Controller
{
    public function store(SellerStoreRequest $request) {
        $data = $request->validated();
        try {
            $success = Seller::register($data);
            if(!$success) {
                return response()->json([
                    'message' => 'Gagal membuat seller',
                ], 500);
            }
            return response()->json([
                'message' => 'Seller berhasil dibuat'
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
            $sellers = Seller::findAll();
            if(!$sellers) {
                return response()->json([
                    'message' => 'No sellers found',
                    'data' => null
                ], 404);
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
