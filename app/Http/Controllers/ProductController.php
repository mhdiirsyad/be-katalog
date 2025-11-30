<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // 1. Ambil List Kategori untuk Dropdown
    public function getCategories() {
        return response()->json(Category::all());
    }

    // 2. Simpan Produk
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Harus ID yang valid
            'photo' => 'required|image|max:2048',
        ]);

        try {
            $user = $request->user(); 

            // Upload Foto
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('products', 'public');
            }

            // Simpan ke DB
            $product = Product::create([
                'seller_id' => $user->id,
                'category_id' => $request->category_id, // Gunakan ID dari dropdown
                'name' => $request->name,
                'weight' => $request->weight,
                'stock' => $request->stock,
                'price' => $request->price,
                'photo' => $photoPath,
                'rating' => 0, // Default 0
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
                'data' => $product
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Gagal upload produk'], 500);
        }
    }

    // 3. Statistik Dashboard Seller
    public function getSellerStats(Request $request) {
        $user = $request->user();
        
        // Ambil produk milik seller beserta info kategorinya
        $products = Product::where('seller_id', $user->id)->with('category')->get();

        // Format data untuk Frontend
        $stockDistribution = $products->map(function($p) {
            return [
                'name' => $p->name, 
                'stock' => $p->stock,
                'category' => $p->category->name
            ];
        });

        $ratingDistribution = $products->map(function($p) {
            return [
                'name' => $p->name, 
                'rating' => $p->rating
            ];
        });

        return response()->json([
            'total_products' => $products->count(),
            'total_stock' => $products->sum('stock'),
            'stock_distribution' => $stockDistribution,
            'rating_distribution' => $ratingDistribution
        ]);
    }
}