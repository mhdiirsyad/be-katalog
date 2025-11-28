<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return response()->json([
            'data' => ProductResource::collection($products),
        ], 200);
    }

    public function show($id) {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        return response()->json([
            'data' => new ProductResource($product),
        ], 200);
    }

    public function store(ProductStoreRequest $request) {
        $data = $request->validated();
        $product = Product::create($data);
        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(ProductStoreRequest $request, $id) {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        $data = $request->validated();
        $product->update($data);
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ], 200);
    }

    public function destroy($id) {
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
