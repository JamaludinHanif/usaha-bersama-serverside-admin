<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Exports\SellersExport;
use App\Imports\ProductImport;
use App\Exports\LogActivityExport;
use App\Exports\TransactionExport;
use Illuminate\Support\Facades\DB;
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

    public function sellerExport()
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (excel) data penjual',
        ]);
        return Excel::download(new SellersExport, 'data-penjual.xlsx');
    }

    // import
    public function productImport(Request $request)
    {
        $request->validate(
            [
                'file' => 'required|mimes:xlsx,xls',
            ],
            [
                'file.required' => 'File wajib diunggah.',
                'file.mimes' => 'Format file harus berupa xlsx, atau xls.',
            ]
        );
        DB::beginTransaction();
        try {
            // Import file
            Excel::import(new ProductImport, $request->file('file'));
            // log activity
            $userId = session('userData')->id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'import (excel) data log activity',
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'success' => 'Data berhasil diimport']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal Mengimport Data', 'details' => $e->getMessage()], 500);
        }
    }
}
