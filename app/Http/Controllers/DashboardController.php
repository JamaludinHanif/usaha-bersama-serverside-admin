<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Paylater;
use App\Models\PaymentCode;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\MyClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // data dari database
        $userCount = User::where('role', 'buyer')->count();
        $productCount = Product::count();
        $transactionCount = Transaction::where('status', 'success')->whereDate('created_at', Carbon::today())->count();

        // perminggu
        $weeklyIncomeBersih = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        // pertahun
        $yearIncomeBersih = Transaction::where('status', 'success')
            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('amount');

        // Mengambil produk terlaris berdasarkan jumlah quantity yang terjual
        $topSellingProducts = TransactionItem::select('product_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(7) // Mengambil 5 produk terlaris
            ->get();

        $products = Product::whereIn('id', $topSellingProducts->pluck('product_id'))->get();

        $topSellingProducts = $topSellingProducts->map(function ($item) use ($products) {
            $product = $products->firstWhere('id', $item->product_id);
            return [
                'products' => $product,
                'total_quantity' => $item->total_quantity,
            ];
        });

        // top kasir
        $topSellers = Transaction::select('seller_id', \DB::raw('SUM(amount) as total_sales'))
            ->with('seller')
            ->groupBy('seller_id')
            ->orderByDesc('total_sales')
            ->take(7)
            ->get();

            // top pembeli
        $topBuyers = Transaction::select('user_id', \DB::raw('SUM(amount) as total_sales'))
            ->groupBy('user_id')
            ->orderByDesc('total_sales')
            ->take(7)
            ->get();

        return view('dashboard.dashboard', [
            // header
            'title' => 'Dashboard',
            'title2' => 'Haloo 🖐️🖐️, selamat datang Admin' . ' ' . session('userData')->username,
            // chart circle
            'jumlahUser' => $userCount,
            'jumlahProduk' => $productCount,
            'jumlahTransaksi' => $transactionCount,
            // data mingguan
            'weeklyIncomeBersih' => $weeklyIncomeBersih,
            // data tahunan
            'yearIncomeBersih' => $yearIncomeBersih,
            // top
            'topSellingProducts' => $topSellingProducts,
            'topSellers' => $topSellers,
            'topBuyers' => $topBuyers,
        ]);
    }

    public function transactionChart()
    {
        $successData = [];
        $billData = [];
        $paylaterData = [];

        // Looping untuk setiap bulan (1-12)
        for ($month = 1; $month <= 12; $month++) {
            // Hitung jumlah transaksi per jenis pembayaran berdasarkan bulan
            $successData[] = Transaction::whereMonth('created_at', $month)
                ->where('status', 'success')
                ->sum('amount');
        }

        // Return data sebagai JSON
        return response()->json([
            'success' => $successData,
        ]);
    }

    public function getWeeklyIncome()
    {
        $today = Carbon::now();

        $weeklyIncome = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->startOfWeek()->addDays($i);
            $income = Transaction::where('status', 'success')->whereDate('created_at', $date)
                ->sum('amount');
            $weeklyIncome[] = $income;
        }

        // Mengembalikan data dalam format JSON
        return response()->json($weeklyIncome);
    }

    public function getTopSellingProducts()
    {
        // Mengambil produk terlaris berdasarkan jumlah quantity yang terjual
        $topSellingProducts = TransactionItem::select('product_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5) // Mengambil 5 produk terlaris
            ->get();

        // Mendapatkan detail produk berdasarkan ID
        $products = Product::whereIn('id', $topSellingProducts->pluck('product_id'))->get();

        // Menggabungkan data produk dan total quantity
        $topSellingProducts = $topSellingProducts->map(function ($item) use ($products) {
            $product = $products->firstWhere('id', $item->product_id);
            return [
                'products' => $product,
                'total_quantity' => $item->total_quantity,
            ];
        });

        return response()->json($topSellingProducts);
    }

    // send message
    public function modalSendMessage($id)
    {
        return view('dashboard.sendWhatsapp', [
            'title' => 'Send message',
            'data' => Paylater::with('user')->where('id', $id)->first(),
        ]);
    }

    public function sendMessage(Request $request)
    {
        // dd($request->all());
        $myClass = new MyClass();
        $responseApiWa = $myClass->sendMessageWhatsapp($request->noHp, $request->message);

        return response()->json($responseApiWa);
    }

    // notes
    public function modalNotes($id)
    {
        return view('dashboard.notes.addNotes', [
            'title' => 'Buat Catatan',
            'data' => User::where('id', $id)->first(),
        ]);
    }

    public function getNotes()
    {
        $notes = Note::with('user')->orderBy('created_at', 'desc')->get();

        foreach ($notes as $note) {
            $note->formatted_created_at = Carbon::parse($note->created_at)->format('d M Y  |  H : i');
        }

        return response()->json($notes);
    }

    public function storeNotes(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'note' => 'required',
        ]);

        $data = $request->all();
        $data['status'] = 1;

        $note = Note::create($data);
        return response()->json(['success' => 'Berhasil menambahkan catatan']);
    }
}
