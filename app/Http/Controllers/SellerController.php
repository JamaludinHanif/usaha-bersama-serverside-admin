<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\Seller;
use App\Models\Transaction;
use App\MyClass\Fonnte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Seller::dataTable($request);
        }

        return view('sellers.index', [
            'title' => 'Kelola Penjual',
        ]);
    }

    public function create()
    {
        return view('sellers.create', [
            'title' => 'Buat Penjual',
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'membuat Penjual ' . $request->shop_name,
            ]);

            $link_login = route('seller.loginView');
            $to = $request->no_hp;

            $message = "Halo 🖐️ *$request->name*,\n\n"
            . "Selamat datang di platform kami! Berikut adalah informasi login anda untuk akun penjual:\n\n"
            . "- Nama Toko: *$request->shop_name*\n"
            . "- Password: *$request->password*\n\n"
            . "Silakan gunakan informasi ini untuk masuk ke akun anda.\n\n"
            . "Login di sini: *$link_login*\n\n"
            . "Jika ada pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami.\n\n"
            . "Terima kasih,\n"
            . "-- Usaha Bersama --";

            $response = Fonnte::sendMessage($to, $message);

            Seller::createSeller($request);
            DB::commit();

            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function edit(Seller $seller)
    {
        return view('sellers.edit', [
            'title' => 'Edit Penjual',
            'seller' => $seller,
        ]);
    }

    public function update(Request $request, Seller $seller)
    {
        DB::beginTransaction();

        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'mengubah Penjual' . $seller->id,
            ]);
            $seller->updateSeller($request);
            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function detail(Seller $seller)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $today = Carbon::now();
        $weeklyIncome = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->startOfWeek()->addDays($i);
            $income = Transaction::where('seller_id', $seller->id)->where('status', 'success')->whereDate('created_at', $date)
                ->sum('amount');
            $weeklyIncome[] = $income;
        }

        $monthlyIncome = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyIncome[] = Transaction::where('seller_id', $seller->id)->whereMonth('created_at', $month)
                ->where('status', 'success')
                ->sum('amount');
        }

        return view('sellers.detail', [
            'title' => 'Detail Penjual',
            'seller' => $seller,
            'weeklyIncomeBersih' => Transaction::where('seller_id', $seller->id)->where('status', 'success')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount'),
            'weeklyIncome' => $weeklyIncome,
            'monthlyIncome' => $monthlyIncome,
        ]);
    }

    public function delete(Request $request, Seller $seller)
    {
        DB::beginTransaction();

        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'menghapus Penjual' . $seller->shop_name,
            ]);
            $seller->deleteSeller();
            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    // recyle/restore
    public function indexRestore()
    {
        return view('admin-recycle.users', [
            'title' => 'Recycle Users',
        ]);
    }

    public function showAllDeleted(Request $request)
    {
        // $data = User::query()->onlyTrashed()->get();
        $query = User::query()->onlyTrashed();

        if (isset($request->role)) {
            $query->where('role', $request->role);
        }

        // Ambil data dari query
        $data = $query->get();

        return Datatables::of($data)
            ->addColumn('role', function ($data) {
                $btnClass = $data->role == 'admin' ? 'btn-info' : 'btn-warning';
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $data->role . '</span>
                    </div></center>';
            })
            ->addColumn('formatted_noHp', function ($data) {
                $urlWhatsapp = "https://wa.me/" . $data->no_hp;
                return '<a href="' . $urlWhatsapp . '" target="_blank">' . $data->no_hp . '</a>';
            })
            ->addColumn('action', function ($data) {
                return view('admin-recycle.action')->with('data', $data);
            })
            ->addColumn('formatted_deleted_at', function ($row) {
                return $row->deleted_at ? $row->deleted_at->format('d-m-Y H:i:s') : '';
            })
            ->rawColumns(['role', 'imageUser', 'formatted_deleted_at', 'formatted_noHp', 'action'])
            ->make(true);
    }

    public function restore(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = Userdcnj::onlyTrashed()->where('id', $id)->restore();
            // log activity
            $userId = $request->admin_id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'merestore akun' . $id,
            ]);
            return response()->json(['success' => 'Berhasil merestore data']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal', 'details' => $e->getMessage()], 500); // Berikan respons error . $e->getMessage()
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::onlyTrashed()->where('id', $id)->forceDelete();
            // log activity
            $userId = $request->admin_id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'mendestroy akun' . $id,
            ]);
            DB::commit();
            return response()->json(['success' => 'Berhasil mendestroy data']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal', 'details' => $e->getMessage()], 500); // Berikan respons error . $e->getMessage()
        }
    }
}
