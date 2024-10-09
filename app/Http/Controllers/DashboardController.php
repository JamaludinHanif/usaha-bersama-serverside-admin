<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // data dari database
        $userCount = User::count();
        $productCount = Product::count();
        $transactionCount = Transaction::whereDate('created_at', Carbon::today())->count();

        return view('dashboard', [
            'title' => 'Dashboard',
            'title2' => 'Haloo 🖐️🖐️, selamat datang Admin' . ' ' . session('userData')->username,
            'jumlahUser' => $userCount,
            'jumlahProduk' => $productCount,
            'jumlahTransaksi' => $transactionCount,
        ]);
    }
}
