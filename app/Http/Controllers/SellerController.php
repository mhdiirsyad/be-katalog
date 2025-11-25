<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function store(SellerStoreRequest $request) {
        $data = $request->validated();
        try {
            // handle uploaded files
            if ($request->hasFile('foto_pic')) {
                $data['foto_pic'] = $request->file('foto_pic')->store('seller_photos', 'public');
            }
            // Upload File KTP
            if ($request->hasFile('file_ktp_pic')) {
                $data['file_ktp_pic'] = $request->file('file_ktp_pic')->store('seller_ktp', 'public');
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

    public function index(Request $request) {
        try {
            $query = Seller::query();

            // Kalau admin kirim ?status=PENDING, cuma muncul yang pending
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $sellers = $query->get();

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

    // 2. FITUR BARU: Approve Seller (Ubah Status jadi ACTIVE)
    public function approve($id) {
        try {
            $seller = Seller::find($id);
            if(!$seller) {
                return response()->json(['message' => 'Seller tidak ditemukan'], 404);
            }

            // Ubah status
            $seller->status = \App\SellerStatus::ACTIVE->name;
            $seller->save();

            // TODO NANTI: Kirim Email Notifikasi "Selamat Akun Aktif" (Sesuai SRS)

            return response()->json([
                'message' => 'Seller berhasil disetujui (ACTIVE)',
                'data' => new SellerResource($seller)
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal approve', 'error' => $e->getMessage()], 500);
        }
    }

    // 3. FITUR BARU: Reject Seller (Ubah Status jadi REJECTED)
    public function reject($id) {
        try {
            $seller = Seller::find($id);
            if(!$seller) {
                return response()->json(['message' => 'Seller tidak ditemukan'], 404);
            }

            $seller->status = \App\SellerStatus::REJECTED->name;
            $seller->save();

            // TODO NANTI: Kirim Email Notifikasi "Maaf Ditolak" (Sesuai SRS)

            return response()->json([
                'message' => 'Seller ditolak (REJECTED)',
                'data' => new SellerResource($seller)
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal reject', 'error' => $e->getMessage()], 500);
        }
    }
}
