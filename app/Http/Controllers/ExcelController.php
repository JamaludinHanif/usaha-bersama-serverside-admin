<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Exports\LogActivityExport;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoryPaymentExport;

class ExcelController extends Controller
{
    // export
    public function transactionExport()
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data transaksi',
        ]);
        return Excel::download(new TransactionExport, 'riwayat-pembelian.xlsx');
    }

    public function paymentsExport()
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data transaksi',
        ]);
        return Excel::download(new HistoryPaymentExport, 'riwayat-pembayaran.xlsx');
    }

    public function productExport()
    {
        // log activity
        dd(session('userData')->name);
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data produk',
        ]);
        return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function userExport()
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data pengguna',
        ]);
        return Excel::download(new UserExport, 'user.xlsx');
    }

    public function logActivityExport()
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data log activity',
        ]);
        return Excel::download(new LogActivityExport, 'log-aktivitas.xlsx');
    }

    // import
    public function productImport(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'import (excel) data log activity',
        ]);
        // <!-- dd($request->file); -->
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            // Import file
            Excel::import(new ProductImport, $request->file('file'));

            return response()->json(['status' => 'success', 'message' => 'Data berhasil diimport']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
