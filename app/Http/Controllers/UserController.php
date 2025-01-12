<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
// use App\Exports\UsersExport;
// use App\Imports\UsersImport;
// use App\Exports\TemplateImport;
// use Intervention\Image\Facades\Image;
use App\Models\Paylater;
use App\Models\PaymentCode;
use App\Models\ReedemCode;
// use Intervention\Image\ImageManager;
// use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transaction;
use App\Models\User;
use App\MyClass\Validations;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

// use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return User::dataTable($request);
        }

        return view('users.index', [
            'title' => 'Kelola Pengguna',
        ]);
    }

    public function store(Request $request)
    {
        Validations::validationUser($request);
        DB::beginTransaction();
        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'membuat pengguna ' . $request->username,
            ]);
            User::createUser($request->all());
            DB::commit();
            return \Res::save();
        } catch (\Exception $e) {
            DB::rollBack();
            return \Res::error($e);
        }
    }

    public function get(User $user)
    {
        try {
            return \Res::success([
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return \Res::error($e);
        }
    }

    public function update(Request $request, User $user)
    {
        Validations::validationUser($request, $user->id);
        DB::beginTransaction();
        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'mengubah pengguna' . $user->id,
            ]);
            $user->updateUser($request);
            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }

    }

    public function delete(User $user)
    {
        DB::beginTransaction();

        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'menghapus pengguna' . $user->username,
            ]);
            $user->deleteUser();
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
                'action' => 'merestore pengguna' . $id,
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

    // APIIIIII

    public function myCart(Request $request)
    {
        $userId = $request->userId;

        // Ambil semua data keranjang berdasarkan user_id dan eager load produk
        $dataCarts = ReedemCode::with('product') // Eager load produk
            ->where('user_id', $userId)
            ->get();

        // Kelompokkan data berdasarkan kode
        $groupedData = $dataCarts->groupBy('code');

        // Formatkan data untuk menampilkan produk
        $formattedData = [];
        foreach ($groupedData as $code => $items) {
            $productData = [];
            foreach ($items as $item) {
                $productData[] = [
                    'id' => $item->product_id,
                    'name' => $item->product->name, // Ambil nama produk dari relasi
                    'quantity' => $item->quantity,
                    'total_amount' => $item->total_amount,
                ];
            }
            $formattedData[] = [
                'code' => $code,
                'products' => $productData,
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil fetch data keranjang',
            'data' => $formattedData,
        ], 200);
    }

    public function myBill(Request $request)
    {
        // $data = Paylater::where('user_id', $request->userId)->with('transaction', 'interest')->get();
        // $dataProduct = TransactionItem::where('transaction_id', $data->transaction->id)->with('product')->get();

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Berhasil fetch data Tagihan',
        //     'data' => $data,
        //     'dataProduct' => $dataProduct,
        // ], 200);

        $data = Paylater::where('user_id', $request->userId)
            ->with(['transaction.items.product', 'interest'])
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil fetch data Tagihan',
            'data' => $data,
        ], 200);

    }

    public function paymentBill(Request $request)
    {
        if ($request->role == "pembeli") {
            // make code payment
            do {
                $uniqueCode = Str::upper(Str::random(8)); // membuat kode acak
            } while (PaymentCode::where('code', $uniqueCode)->exists());

            $transaction = Transaction::create([
                'total_amount' => $request->nominalPayment,
                'kode_invoice' => "belum jadi",
                'user_id' => $request->userId,
                'type' => "payment bill",
                'status' => 'pending',
                'interest_id' => $request->interestId,
            ]);

            PaymentCode::create([
                'transaction_id' => $transaction->id,
                'user_id' => $request->userId,
                'code' => $uniqueCode,
                'type' => "payment bill",
                'type_sending' => $request->methodSending, //
                'status' => "pending",
                'new_purchase' => false,
                'amount' => $request->nominalPayment,
                'cashier_id' => null,
                'interest_id' => $request->interestId,
                'paylater_id' => $request->paylaterId,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil generate kode pembayaran',
                'data' => $request->all(),
                'code' => $uniqueCode,
            ], 200);
        } else {
            $data = Paylater::where('id', $request->paylaterId)->get();

            $data->decrement('debt_remaining', $request->nominalPayment);

            return response()->json([
                'status' => true,
                'message' => 'berhasil konfirmasi pembayaran',
                'data' => $data,
            ], 200);
        }

        // log activity
        LogActivity::create([
            'user_id' => $request->userId,
            'action' => 'melakukan pembayaran tagihan' . $request->paylaterId,
        ]);
    }
}
