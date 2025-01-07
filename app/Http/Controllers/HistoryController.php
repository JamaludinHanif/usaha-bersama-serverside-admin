<?php

namespace App\Http\Controllers;

use App\Models\PaymentCode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class HistoryController extends Controller
{
    // transaksi
    public function index(Request $request)
    {
		if($request->ajax()) {
			return Transaction::dataTable($request);
		}

		return view('transactions.index', [
			'title' => 'Kelola Transaksi',
		]);
    }

    public function detail(Transaction $transaction)
    {
        return view('transactions.detail', [
            'title' => 'Detail Transaksi',
            'datas' => $transaction,
        ]);
    }

    // api
    public function myHistory(Request $request)
    {
        $data = PaymentCode::where('user_id', $request->userId)->orderBy('created_at', 'desc')->with(['user', 'cashier', 'transaction.items.product', 'interest'])->get();

        return response()->json([
            'status' => true,
            'message' => 'berhasil get data History',
            'data' => $data,
        ], 200);
    }
}
