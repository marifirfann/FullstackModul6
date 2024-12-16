<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET: List of Products
    public function index()
    {
        return ProductResource::collection(Products::all());
    }

    // POST: Create Product
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'stok' => 'sometimes|required|numeric',
        ]);

        $product = Products::create($request->only(['nama_produk', 'harga', 'deskripsi', 'stok', 'pembeli_id']));
        return new ProductResource($product);
    }

    // GET: Product by ID
    public function show($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }
        return new ProductResource($product);
    }

    // PUT: Update Product
    public function update(Request $request, $id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }

        $request->validate([
            'nama_produk' => 'sometimes|required',
            'harga' => 'sometimes|required|numeric',
            'deskripsi' => 'sometimes|required',
            'stok' => 'sometimes|required|numeric',
            'pembeli_id' => 'sometimes|required|exists:pembelis,id',
        ]);

        $product->update($request->only(['nama_produk', 'harga', 'deskripsi', 'stok', 'pembeli_id']));
        return response()->json(['message' => 'Produk berhasil diperbarui', 'data' => $product], 200);
    }

    // DELETE: Delete Product
    public function destroy($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'produk berhasil dihapus'], 200);
    }
}
