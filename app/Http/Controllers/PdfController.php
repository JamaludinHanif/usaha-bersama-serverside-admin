<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\PaymentCode;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function PdfUser(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (pdf) data pengguna',
        ]);

        // Membuat instance mPDF
        $mpdf = new Mpdf([
            'orientation' => 'P',
        ]);

        $role = $request->input('role');

        // Query data user berdasarkan filter jika diperlukan
        $users = User::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Pengguna',
            'date' => date('d/F/Y'),
            'users' => $users,
        ];

        // // Konten yang akan dimasukkan ke PDF
        // $html = '<h1>Ini adalah contoh PDF menggunakan mPDF di Laravel 9</h1>';

        // // Menulis konten ke PDF
        // $mpdf->WriteHTML($html);

        $users = User::all();

        $html = view('pdf.userData', $data)->render();
        $mpdf->WriteHTML($html);

        // Mengirimkan file PDF ke browser untuk didownload
        return $mpdf->Output('data-user.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    public function PdfHistoryTransactions(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (pdf) data transaksi',
        ]);

        // Membuat instance mPDF
        $mpdf = new Mpdf([
            'orientation' => 'P',
        ]);

        $transaction = Transaction::query();

        if (isset($request->date)) {
            $transaction->whereDate('created_at', $request->date);
        }
        if (isset($request->status)) {
            $transaction->where('status', $request->status);
        }
        if (isset($request->type)) {
            $transaction->where('type', $request->type);
        }

        $transactions = $transaction->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Transaksi',
            'date' => date('d/F/Y'),
            'transactions' => $transactions,

        ];

        $html = view('pdf.historyTransactionsData', $data)->render();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('data-transaksi.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    public function PdfHistoryPayments(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (pdf) data transaksi',
        ]);

        // Membuat instance mPDF
        $mpdf = new Mpdf([
            'orientation' => 'P',
        ]);

        $payment = PaymentCode::query();

        if (isset($request->date)) {
            $payment->whereDate('created_at', $request->date);
        }
        if (isset($request->status)) {
            $payment->where('status', $request->status);
        }
        if (isset($request->type)) {
            $payment->where('type', $request->type);
        }

        $payments = $payment->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Pembayaran',
            'date' => date('d/F/Y'),
            'payments' => $payments,
        ];

        $html = view('pdf.historyPaymentData', $data)->render();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('data-pembayaran.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    public function PdfLog(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (pdf) data log activity',
        ]);

        $mpdf = new Mpdf();

        $date = $request->input('date');

        $logs = LogActivity::with('user');

        if (isset($request->date)) {
            $logs->whereDate('created_at', $request->date);
        }

        if (isset($request->role)) {
            $logs->whereHas('user', function ($query) use ($request) {
                $query->where('role', $request->role);
            });
        }

        $logs = $logs->get();

        $data = [
            'title' => 'Laporan Data Log Aktivitas',
            'type' => $date ? 'byDate' : 'all',
            'logs' => $logs,
        ];

        $logs = LogActivity::all();

        $html = view('pdf.logActivityPdf', $data)->render();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('data-log.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    public function PdfProduct(Request $request)
    {
        // log activity
        $userId = session('userData')->id;
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'export (pdf) data produk',
        ]);

        // Membuat instance mPDF
        $mpdf = new Mpdf([
            'orientation' => 'P',
        ]);

        $product = Product::query();

        if (isset($request->unit)) {
            $product->where('unit', $request->unit);
        }
        if (isset($request->category)) {
            $product->where('category', $request->category);
        }

        $products = $product->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Produk',
            'date' => date('d/F/Y'),
            'products' => $products,
        ];

        $html = view('pdf.productData', $data)->render();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('data-product.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    // user download
    public function exportInvoice(Request $request)
    {
        $data = PaymentCode::where('id', $request->payment_id)->with('interest', 'transaction.items.product', 'user')->first();

        // log activity
        LogActivity::create([
            'user_id' => $request->userId,
            'action' => 'mendownload invoice',
        ]);

        if ($data->type == "paylater") {
            $dataPdf = [
                'noInvoice' => $data->transaction->kode_invoice,
                'name' => $data->user->name,
                // pembelian baru
                'dataProduk' => $data->transaction->items,
                'totalHarga' => $data->transaction->total_amount,
                'dataBunga' => $data->interest,
            ];

            // instance mPDF
            $mpdf = new \Mpdf\Mpdf();
            // view sebagai konten PDF
            $html = view('pdf.invoice-pembelian.invoicePaylater', $dataPdf)->render();
        } else if ($data->type == "cash") {
            $dataPdf = [
                'noInvoice' => $data->transaction->kode_invoice,
                'name' => $data->user->name,
                // pembelian baru
                'dataProduk' => $data->transaction->items,
                'totalHarga' => $data->transaction->total_amount,
            ];
            // instance mPDF
            $mpdf = new \Mpdf\Mpdf();
            // view sebagai konten PDF
            $html = view('pdf.invoice-pembelian.invoiceCash', $dataPdf)->render();
        } else {
            $dataPdf = [
                'noInvoice' => $data->transaction->kode_invoice,
                'name' => $data->user->name,
                // pembayaran tagihan
                'nominalPembayaran' => $data->amount,
                'dataPaylater' => $data->interest,
            ];

            // instance mPDF
            $mpdf = new \Mpdf\Mpdf();
            // view sebagai konten PDF
            $html = view('pdf.invoice-pembelian.invoicePembayaranTagihan', $dataPdf)->render();
        }

        $mpdf->WriteHTML($html);

        if ($request->type == 'D') {
            // Tambahkan header CORS di sini
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
        }

        return $mpdf->Output('invoice.pdf', $request->type); // 'D' untuk force download, 'I' untuk inline di browser

        // return response()->json([
        //     'status' => true,
        //     'message' => 'berhasil download invoice',
        //     'data' => $request->all(),
        // ], 200);
    }

}