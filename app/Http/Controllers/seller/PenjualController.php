<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualController extends Controller
{
    public function index()
    {
        return view('seller.index', [
            'title' => 'HomePage Seller',
            'data' => Seller::where('id', session('userData')->id)->first(),
        ]);
    }

    public function changeStatus(Request $request)
    {
        DB::beginTransaction();
        try {

            $seller = Seller::where('id', session('userData')->id)->first();
            $seller->update([
                'status' => $request->status,
            ]);

            if ($request->status == 'Buka') {
                LogActivity::create([
                    'user_id' => 18,
                    'action' => "melakukan buka toko " . session('userData')->shop_name,
                ]);
            }

            if ($request->status == 'Tutup') {
                LogActivity::create([
                    'user_id' => 18,
                    'action' => "melakukan tutup toko " . session('userData')->shop_name,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Operasi berhasil', 'data' => $request->all()], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Pendaftaran gagal. Silakan coba lagi.', 'details' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}"], 500);
        }
    }

    public function indexOrder()
    {
        return view('seller.order', [
            'title' => 'Pesanan',
        ]);
    }

    public function confirmOrder($code)
    {
        return view('seller.confirmation_order', [
            'title' => 'Detail',
            'datas' => Transaction::where('seller_id', session('userData')->id)->where('code_invoice', $code)->with(['user', 'seller', 'items.product'])->first(),
        ]);
    }

    public function detailOrder($code)
    {
        return view('seller.history_detail', [
            'title' => 'Detail',
            'datas' => Transaction::where('seller_id', session('userData')->id)->where('code_invoice', $code)->with(['user', 'seller', 'items.product'])->first(),
        ]);
    }

    public function history()
    {
        return view('seller.history', [
            'title' => 'Riwayat Pesanan',
        ]);
    }

    public function cashier()
    {
        return view('seller.cashier', [
            'title' => 'Kasir',
        ]);
    }

    public function getProducts(Request $request)
    {
        $search = $request->get('search', '');
        $products = Product::where('name', 'like', "%{$search}%")
            ->select('id', 'name', 'price')
            ->get();

        return response()->json($products);
    }

    public function searchSeller(Request $request)
    {
        $query = $request->input('query');
        $sellers = Seller::where('status', 'Buka')->where('shop_name', 'LIKE', "%{$query}%")
            ->orWhere('location', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($sellers);
    }
}
