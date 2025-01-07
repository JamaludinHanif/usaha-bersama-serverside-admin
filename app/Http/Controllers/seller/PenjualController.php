<?php

namespace App\Http\Controllers\seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenjualController extends Controller
{
    public function index()
    {
        return view('seller.index', [
            'title' => 'HomePage Seller'
        ]);
    }

    public function searchSeller(Request $request)
    {
        $query = $request->input('query');
        $sellers = Seller::where('shop_name', 'LIKE', "%{$query}%")
            ->orWhere('location', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($sellers);
    }
}
