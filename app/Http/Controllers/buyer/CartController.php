<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return view('buyer.cart', [
            'title' => 'Keranjang',
            'items' => Cart::where('user_id', session('userData')->id)->with('product', 'user')->orderBy('created_at', 'asc')->get(),
        ]);
    }

    // Menambahkan produk ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Produk harus dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak valid.',
            'quantity.required' => 'Jumlah produk harus diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka.',
            'quantity.min' => 'Jumlah produk minimal 1.',
        ]);
        DB::beginTransaction();
        try {
            $existingCart = Cart::where('user_id', session('userData')->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingCart) {
                $existingCart->update([
                    'quantity' => $existingCart->quantity + $request->quantity,
                ]);
                DB::commit();
                return response()->json(['info' => 'Produk ini sudah ada di keranjang!', 'data' => $existingCart]);
            }

            $cart = Cart::updateOrCreate(
                [
                    'user_id' => session('userData')->id,
                    'product_id' => $request->product_id,
                ],
                [
                    'quantity' => $request->quantity,
                ]
            );
            $cartCount = Cart::where('user_id', session('userData')->id)->count();
            DB::commit();
            return response()->json(['success' => 'Produk berhasil ditambahkan ke keranjang!', 'cartCount' => $cartCount]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateQuantity(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $cart = Cart::where('user_id', session('userData')->id)
                ->where('product_id', $request->product_id)
                ->first();

            $cart->update([
                'quantity' => $request->quantity,
            ]);
            DB::commit();
            return response()->json(['success' => 'Berhasil Menambah Quantitas']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::where('id', $id)->where('user_id', session('userData')->id)->first();
            if ($cart) {
                $cart->delete();
                $cartCount = Cart::where('user_id', session('userData')->id)->count();
                DB::commit();
                return response()->json(['success' => 'Item telah berhasil dihapus dari keranjang!', 'cartCount' => $cartCount]);
            }
            DB::rollback();
            return response()->json(['error' => 'Item tidak ditemukan!'], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

}
