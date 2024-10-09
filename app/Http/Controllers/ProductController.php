<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Mail\SendInvoice;
use App\Models\ReedemCode;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // admin section
    public function index()
    {
        return view('admin-products.kelola-products.products', [
            'title' => 'Kelola Produk',
            'users' => User::all()
        ]);
    }

    public function showAll(Request $request)
    {
        $data = Product::query();

        // dd($request->category . '' . $request->unit);

        if (isset($request->category)) {
            $data->where('category', $request->category);
        }

        if (isset($request->unit)) {
            $data->where('unit', $request->unit);
        }

        return Datatables::of($data)
        ->addColumn('category', function($data) {
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
        ->addColumn('unit', function($data) {
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
        ->addColumn('action', function($data){
            return view('admin-products.kelola-products.action')->with('data', $data);
        })
        ->addColumn('image', function($data) {
            // Ganti $data->image dengan $data->image untuk mendapatkan nilai gambar dari data
            $imageUrl = $data->image == null
                ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSI3-0UOb16mRek6YkvKr4wuBpEmwYfWhav0w&s'
                : $data->image;

            // Kembalikan HTML yang diinginkan
            return '<div class="d-flex justify-content-center">
                        <img src="' . $imageUrl . '" width="50" alt="">
                    </div>';
        })
        ->addColumn('formatted_amount', function($row) {
            return $row->price ? 'Rp ' . number_format($row->price, 0, ',', '.') : '';
        })
        ->rawColumns(['category', 'unit', 'image', 'formatted_amount', 'action'])
        ->make(true);
    }

    public function showFormCreate()
    {
        return view('admin-products.kelola-products.addProducts', [
            'title' => 'Products Baru',
        ]);
    }

    public function store(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'price'=> 'required',
            'category' => 'required',
            'unit' => 'required',
            'stock' => 'required',
        ], [
            'name.required' => 'Nama wajib di isi',
            'price.required' => 'Harga wajib di isi',
            'category.required' => 'Kategori wajib di isi',
            'unit.required' => 'Satuan wajib di isi',
            'stock.required' => 'Stok wajib di isi',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'unit' => $request->unit,
                'stock' => $request->stock,
                'image' => $request->image,
            ];
            Product::create($data);
            return response()->json(['success' => 'Berhasi menyimpan data']);
        }

    }

    public function editProduct($id)
    {
        return view('admin-products.kelola-products.editProducts', [
            'title' => 'Edit Produk',
            'data' => Product::where('id', $id)->first()
        ]);
        // $data = Quotes::where('id', $id)->first();
        // return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $produk = Product::findOrFail($id);
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'price'=> 'required',
            'category' => 'required',
            'unit' => 'required',
            'stock' => 'required',
        ], [
            'name.required' => 'Nama wajib di isi',
            'price.required' => 'Harga wajib di isi',
            'category.required' => 'Kategori wajib di isi',
            'unit.required' => 'Satuan wajib di isi',
            'stock.required' => 'Stok wajib di isi',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
                'price' => $request->price,
                'category' => $request->category,
                'unit' => $request->unit,
                'stock' => $request->stock,
                'image' => $request->image,
            ];
            Product::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasi mengupdate data']);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $quote = Product::findOrFail($id);
            $quote->delete();
            // toast('User berhasil di ubah','success');
            return response()->json(['success' => 'Berhasil menghapus data'], 200); // Berikan respons sukses
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500); // Berikan respons error
        }
    }

    // recycle section
    public function indexRecycle()
    {
        return view('admin-recycle.products', [
            'title' => 'Recycle Products',
        ]);
    }

    public function showAllRecycle(Request $request)
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
        ->addColumn('category', function($data) {
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
        ->addColumn('unit', function($data) {
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
        ->addColumn('action', function($data){
            return view('admin-recycle.action')->with('data', $data);
        })
        ->addColumn('image', function($data) {
            // Ganti $data->image dengan $data->image untuk mendapatkan nilai gambar dari data
            $imageUrl = $data->image == null
                ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSI3-0UOb16mRek6YkvKr4wuBpEmwYfWhav0w&s'
                : $data->image;

            // Kembalikan HTML yang diinginkan
            return '<div class="d-flex justify-content-center">
                        <img src="' . $imageUrl . '" width="50" alt="">
                    </div>';
        })
        ->addColumn('formatted_amount', function($row) {
            return $row->price ? 'Rp ' . number_format($row->price, 0, ',', '.') : '';
        })
        ->rawColumns(['category', 'unit', 'image', 'formatted_amount', 'action'])
        ->make(true);
    }

    public function restore($id)
    {
        // dd($id);
        $product = Product::onlyTrashed()->where('id', $id)->restore();

        return response()->json(['success' => 'Berhasil merestore data']);
    }

    public function destroy($id)
    {
        // dd($id);
        $product = Product::onlyTrashed()->where('id', $id)->forceDelete();

        return response()->json(['success' => 'Berhasil mendestroy data']);
    }

    // api section
    public function showAllApi(Request $request)
    {
        $data = Product::all();
        $data = $data->map(function($item) {
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

    public function searchProduct(Request $request)
    {
        // return $request;
        $search = $request->name;
        $data = Product::where('name', 'like', '%' . $search . '%')->get();

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
            $data = $reedemCodes->map(function($reedemCode) {
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
                    'updated_at' => $reedemCode->updated_at
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
