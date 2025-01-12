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
        return view('dashboard.dashboard', [
            'title' => 'Dashboard',
            'title2' => 'Haloo 🖐️🖐️, selamat datang Admin' . ' ' . session('userData')->username,
        ]); // sementara
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // data dari database
        $userCount = User::count();
        $productCount = Product::count();
        $transactionCount = Transaction::where('status', 'success')->whereDate('created_at', Carbon::today())->count();
        $listDebt = Paylater::with('user')->where('status', '1')->get();

        // perminggu
        $interestWeeklyIncome = \DB::table('paylaters')
            ->join('transactions', 'paylaters.transaction_id', '=', 'transactions.id')
            ->join('interest_bills', 'paylaters.interest_id', '=', 'interest_bills.id')
            ->whereBetween('paylaters.created_at', [$startOfWeek, $endOfWeek]) // optional
            ->selectRaw('SUM(transactions.total_amount * (interest_bills.interest / 100)) as total_interest')
            ->value('total_interest');
        $weeklyIncomeBersih = PaymentCode::where('status', 'success')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');
        $weeklyIncomeKotor = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total_amount');

        // pertahun
        $yearIncomeBersih = PaymentCode::where('status', 'success')
            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('amount');
        $yearIncomeKotor = Transaction::where('status', 'success')
            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('total_amount');
        $yearBill = Paylater::where('status', '1')
            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->sum('debt_remaining');
        $interestYearIncome = \DB::table('paylaters')
            ->join('transactions', 'paylaters.transaction_id', '=', 'transactions.id')
            ->join('interest_bills', 'paylaters.interest_id', '=', 'interest_bills.id')
            ->whereBetween('paylaters.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]) // optional
            ->selectRaw('SUM(transactions.total_amount * (interest_bills.interest / 100)) as total_interest')
            ->value('total_interest');

        // Mengambil produk terlaris berdasarkan jumlah quantity yang terjual
        $topSellingProducts = TransactionItem::select('product_id', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(5) // Mengambil 5 produk terlaris
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
        $topCashiers = PaymentCode::select('cashier_id', \DB::raw('SUM(amount) as total_sales'))
            ->groupBy('cashier_id') // Kelompokkan berdasarkan cashier_id
            ->orderByDesc('total_sales') // Urutkan berdasarkan total_sales yang terbesar
            ->take(7) // Ambil 5 kasir teratas
            ->get();

            // top pembeli
        $topBuyers = PaymentCode::select('user_id', \DB::raw('SUM(amount) as total_sales'))
            ->groupBy('user_id')
            ->orderByDesc('total_sales')
            ->take(5)
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
            'interestWeeklyIncome' => $interestWeeklyIncome,
            'weeklyIncomeBersih' => $weeklyIncomeBersih,
            'weeklyIncomeKotor' => $weeklyIncomeKotor,
            // data tahunan
            'yearIncomeBersih' => $yearIncomeBersih,
            'yearIncomeKotor' => $yearIncomeKotor,
            'interestYearIncome' => $interestYearIncome,
            'yearBill' => $yearBill,
            'topSellingProducts' => $topSellingProducts,
            'topCashiers' => $topCashiers,
            'topBuyers' => $topBuyers,
            // data hutang
            'debts' => $listDebt,
        ]);
    }

    public function transactionChart()
    {
        $cashData = [];
        $billData = [];
        $paylaterData = [];

        // Looping untuk setiap bulan (1-12)
        for ($month = 1; $month <= 12; $month++) {
            // Hitung jumlah transaksi per jenis pembayaran berdasarkan bulan
            $cashData[] = PaymentCode::whereMonth('created_at', $month)
                ->where('type', 'cash')
                ->sum('amount');

            $billData[] = PaymentCode::whereMonth('created_at', $month)
                ->where('type', 'payment bill')
                ->sum('amount');

            $paylaterData[] = PaymentCode::whereMonth('created_at', $month)
                ->where('type', 'paylater')
                ->sum('amount');
        }

        // Return data sebagai JSON
        return response()->json([
            'cash' => $cashData,
            'bill' => $billData,
            'paylater' => $paylaterData,
        ]);
    }

    public function getWeeklyIncome()
    {
        $today = Carbon::now();

        $weeklyIncome = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->startOfWeek()->addDays($i);
            $income = PaymentCode::where('status', 'success')->whereDate('created_at', $date)
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
