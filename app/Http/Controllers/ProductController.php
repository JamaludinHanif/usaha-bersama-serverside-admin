<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\Product;
use App\Models\ReedemCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Product::dataTable($request);
        }

        return view('products.index', [
            'title' => 'Kelola Produk',
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'title' => 'Buat Produk',
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'membuat produk ' . $request->username,
            ]);
            Product::createProduct($request);
            DB::commit();

            return \Res::save();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'title' => 'Edit Produk',
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'slug' => 'required|unique:products,slug,' . $product->id,
        ], [
            'slug.unique' => 'Slug tidak tersedia',
        ]);

        DB::beginTransaction();

        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'mengubah produk' . $product->id,
            ]);
            $product->updateProduct($request);
            DB::commit();

            return \Res::update();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function detail(Product $product)
    {

        return view('products.detail', [
            'title' => 'Detail Produk',
            'product' => $product,
        ]);
    }

    public function delete(Request $request, Product $product)
    {
        DB::beginTransaction();

        try {
            LogActivity::create([
                'user_id' => session('userData')->id,
                'action' => 'menghapus produk' . $product->name,
            ]);
            $product->deleteProduct();
            DB::commit();

            return \Res::delete();
        } catch (\Exception $e) {
            DB::rollback();

            return \Res::error($e);
        }
    }

    public function importProduct()
    {
        return view('products.import', [
            'title' => 'Import Produk',
        ]);
    }

    // recycle section
    public function indexRestore()
    {
        return view('admin-recycle.products', [
            'title' => 'Recycle Products',
        ]);
    }

    public function showRestore(Request $request)
    {
        $data = Product::query()->onlyTrashed();

        // dd($request->category . '' . $request->unit);

        if (isset($request->category)) {
            $data->where('category', $request->category);
        }

        if (isset($request->unit)) {
            $data->where('unit', $request->unit);
        }

        return Datatables::of($data)
            ->addColumn('category', function ($data) {
                $btnClass = $data->category == 'minuman'
                ? 'btn-info'
                : ($data->category == 'makanan'
                    ? 'btn-success'
                    : ($data->category == 'pembersih'
                        ? 'btn-danger'
                        : 'btn-warning'));

                return '<div class="' . $btnClass . '"
                        style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->category .
                    '</div>';
            })
            ->addColumn('unit', function ($data) {
                $btnClass2 = $data->unit == 'pcs'
                ? 'btn-info'
                : ($data->unit == 'dos'
                    ? 'btn-success'
                    : ($data->unit == 'pak'
                        ? 'btn-danger'
                        : 'btn-warning'));

                return '<div class="' . $btnClass2 . '"
                        style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->unit .
                    '</div>';
            })
            ->addColumn('action', function ($data) {
                return view('admin-recycle.action')->with('data', $data);
            })
            ->addColumn('image', function ($data) {
                // Ganti $data->image dengan $data->image untuk mendapatkan nilai gambar dari data
                $imageUrl = $data->image == null
                ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSI3-0UOb16mRek6YkvKr4wuBpEmwYfWhav0w&s'
                : $data->image;

                // Kembalikan HTML yang diinginkan
                return '<div class="d-flex justify-content-center">
                        <img src="' . $imageUrl . '" width="50" alt="">
                    </div>';
            })
            ->addColumn('formatted_amount', function ($row) {
                return $row->price ? 'Rp ' . number_format($row->price, 0, ',', '.') : '';
            })
            ->rawColumns(['category', 'unit', 'image', 'formatted_amount', 'action'])
            ->make(true);
    }

    public function restore(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::onlyTrashed()->where('id', $id)->restore();
            // log activity
            $userId = $request->admin_id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'merestore produk' . $id,
            ]);
            DB::commit();
            return response()->json(['success' => 'Berhasil merestore data']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal', 'details' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::onlyTrashed()->where('id', $id)->forceDelete();
            // log activity
            $userId = $request->admin_id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'menghancurkan produk' . $id,
            ]);
            DB::commit();
            return response()->json(['success' => 'Berhasil mendestroy data']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal', 'details' => $e->getMessage()], 500);
        }
    }

    // api section
    public function showApi(Request $request)
    {
        $data = Product::all();
        $data = $data->map(function ($item) {
            $item->value = $item->id;
            $item->label = $item->name . " " . " " . " " . "-" . $item->unit;
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Load berhasil',
            'data' => $data,
        ], 200);
    }

    public function detailApi(Request $request)
    {
        $slug = $request->slug;
        $data = Product::where('slug', $slug)->first();

        return response()->json([
            'status' => true,
            'message' => 'Load berhasil',
            'data' => $data,
        ], 200);
    }

    public function addRedeemCode(Request $request)
    {

        do {
            $uniqueCode = Str::upper(Str::random(8)); // Menghasilkan kode acak
        } while (ReedemCode::where('code', $uniqueCode)->exists());

        $productItems = [];

        foreach ($request->data as $productData) {
            $product = Product::find($productData['value']['id']);
            $quantity = $productData['quantity'];
            $totalAmount = $productData['totalPrice'];

            if ($product && $quantity > 0) {
                $productId = $product->id;
                $productItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'totalPrice' => $totalAmount,
                ];
            }
        }

        if ($productId !== null) {
            // $transaction = Transaction::create(['total_amount' => $totalAmount]);

            foreach ($productItems as $item) {
                ReedemCode::create([
                    'user_id' => $request->userId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'total_amount' => $item['totalPrice'],
                    'code' => $uniqueCode,
                ]);
                // Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

        }

        return response()->json([
            'status' => true,
            'message' => 'berhasil membuat code',
            'data' => $uniqueCode,
        ], 200);
    }

    public function reedemCode(Request $request)
    {
        $code = $request->code;

        // Ambil semua reedem codes berdasarkan kode dan sertakan informasi produk terkait
        $reedemCodes = ReedemCode::where('code', $code)
            ->with('product') // Pastikan relasi 'product' sudah didefinisikan di model ReedemCode
            ->get();

        if ($reedemCodes->isNotEmpty()) {
            $data = $reedemCodes->map(function ($reedemCode) {
                return [
                    'reedem_code_id' => $reedemCode->id,
                    'code' => $reedemCode->code,
                    'user_id' => $reedemCode->user_id,
                    'product_id' => $reedemCode->product_id,
                    'quantity' => $reedemCode->quantity,
                    'total_amount' => $reedemCode->total_amount,
                    'product' => [
                        'id' => $reedemCode->product->id,
                        'name' => $reedemCode->product->name,
                        'unit' => $reedemCode->product->unit,
                        'price' => $reedemCode->product->price,
                        'category' => $reedemCode->product->category,
                    ],
                    'label' => $reedemCode->product->name . ' - ' . $reedemCode->product->unit, // Label untuk ditampilkan
                    'value' => $reedemCode->product->id, // Value untuk dipakai
                    'created_at' => $reedemCode->created_at,
                    'updated_at' => $reedemCode->updated_at,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Berhasil fetch data by code',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan, silahkan periksa kembali !',
                // 'data' => $data,
            ], 200);
        }
    }

}
