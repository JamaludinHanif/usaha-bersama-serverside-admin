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
                ? 'bg-gradient-info'
                : ($data->category == 'makanan'
                    ? 'bg-gradient-success'
                    : 'bg-gradient-warning');

            return '<div class="' . $btnClass . '"
                        style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                    . $data->category .
                    '</div>';
        })
        ->addColumn('unit', function($data) {
            $btnClass2 = $data->unit == 'pcs'
                ? 'bg-gradient-info'
                : ($data->unit == 'dos'
                    ? 'bg-gradient-success'
                    : 'bg-gradient-warning');

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
                ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNzGEZOcNeFcmMALAjPBHYCgCcYzTNL54VXw&s'
                : $data->image;

            // Kembalikan HTML yang diinginkan
            return '<div class="d-flex justify-content-center">
                        <img src="' . $imageUrl . '" width="50" alt="">
                    </div>';
        })
        ->rawColumns(['category', 'unit', 'image', 'action'])
        ->make(true);
    }

    public function showFormCreate()
    {
        return view('admin-quotes.kelola-quotes.addQuotes', [
            'title' => 'New Quotes',
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // $validatedData = $request->validate([
        //     'name' => 'required|max:100',  //versi biasa
        //     'username' => ['required', 'min:3', 'max:100', 'unique:users'], //versi menggunakan array
        //     'role' => 'required',
        //     'email' => ['required', 'email:dns', 'unique:users'],
        //     'password' => 'required|min:5|max:100',

        // ]);

        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title'=> 'required|unique:quotes',
            'quote' => 'required|max:255'
        ], [
            'user_id.required' => 'User wajib di isi',
            'category_id.required' => 'Kategori wajib di isi',
            'title.required' => 'Judul wajib di isi',
            'title.unique' => 'Judul sudah dipakai, tolong gunakan judul yang lain',
            'title.max' => 'Judul terlalu panjang, max 100 karacter',
            'quote.required' => 'Quote wajib di isi',
            'quote.max' => 'Quote terlalu panjang, max 255 karakter'
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'quote' => $request->quote
            ];
            Quotes::create($data);
            return response()->json(['success' => 'Berhasi menyimpan data']);
        }

    }

    public function editQuotes($id)
    {
        return view('admin-quotes.kelola-quotes.editQuotes', [
            'title' => 'Edit Quote',
            'users' => User::all(),
            'categories' => Category::all(),
            'datas' => Quotes::where('id', $id)->first()
        ]);
        // $data = Quotes::where('id', $id)->first();
        // return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $quote = Quotes::findOrFail($id);
        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title'=> [
                'required',
                Rule::unique('quotes')->ignore($quote->id), // Mengabaikan validasi unique untuk ID yang sedang diupdate
                'max:100'
            ],
            'quote' => 'required|max:255'
        ], [
            'user_id.required' => 'User wajib di isi',
            'category_id.required' => 'Kategori wajib di isi',
            'title.required' => 'Judul wajib di isi',
            'title.unique' => 'Judul sudah dipakai, tolong gunakan judul yang lain',
            'title.max' => 'Judul terlalu panjang, max 100 karacter',
            'quote.required' => 'Quote wajib di isi',
            'quote.max' => 'Quote terlalu panjang, max 255 karakter'
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'quote' => $request->quote
            ];
            Quotes::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasi mengupdate data']);
        }
    }

    public function deleteQuotes($id)
    {
        dd($id);
        try {
            $quote = Quotes::findOrFail($id);
            $quote->delete();
            // toast('User berhasil di ubah','success');
            return response()->json(['success' => 'Berhasil menghapus data'], 200); // Berikan respons sukses
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500); // Berikan respons error
        }
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

    public function preCheckout(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Load berhasil',
            'data' => $request->all(),
        ], 200);
        // $cart = session()->get('cart', []);

        // // Loop melalui setiap item di dalam data
        // foreach ($request->data as $item) {
        //     // Tambahkan item ke dalam cart
        //     $cart[] = [
        //         'id' => $item['id'],
        //         'price' => $item['price'],
        //         'quantity' => $item['quantity'],
        //         'value' => $item['value'],
        //     ];
        // }

        // // Simpan cart yang diperbarui ke session
        // session()->put('cart', $cart);

        // return response()->json(['message' => 'Item added to cart', 'cart' => $cart]);
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

    public function checkOutV1(Request $request)
    {
        // return $request->all();
        $formattedDate = now()->format('dmy-H:i:s');
        $noInvoice = 'INV-' . $formattedDate . '-' . $request->userId;
        // $request->userId
        // Data yang akan dimasukkan ke dalam PDF
        $data123 = [
            'data' => [
                "id" => 1,
                "price" => 23000,
                "quantity" => 1,
                "totalPrice" => 0,
                "value" => [
                    "id" => 3,
                    "category" => "minuman",
                    "created_at" => "2024-09-20T02:23:51.000000Z",
                    "deleted_at" => null,
                    "expired_date" => null,
                    "image" => "https://down-id.img.susercontent.com/file/id-11134207-7r98v-ltd9jl2olv6v94",
                    "label" => "Teh gelas cup kecil isi 24   -dos",
                    "name" => "Teh gelas cup kecil isi 24",
                    "price" => 23000,
                    "stock" => 5,
                    "unit" => "dos",
                    "updated_at" => "2024-09-20T02:23:51.000000Z",
                    "value" => 3
                ]
                ],
                [
                    "id" => 1,
                    "price" => 23000,
                    "quantity" => 3,
                    "totalPrice" => 0,
                    "value" => [
                        "id" => 3,
                        "category" => "minuman",
                        "created_at" => "2024-09-20T02:23:51.000000Z",
                        "deleted_at" => null,
                        "expired_date" => null,
                        "image" => "https://down-id.img.susercontent.com/file/id-11134207-7r98v-ltd9jl2olv6v94",
                        "label" => "Teh gelas cup kecil isi 24   -dos",
                        "name" => "Teh gelas cup kecil isi 24",
                        "price" => 23000,
                        "stock" => 5,
                        "unit" => "dos",
                        "updated_at" => "2024-09-20T02:23:51.000000Z",
                        "value" => 3
                    ]
                    ],
            'totalPrice' => 23000
            ];

        $data = [
            'data' => $request->all(),
            'name' => $request->name,
            'noInvoice' => $noInvoice
        ];

        // return $data;

        // // database section
        // $totalAmount = 0;
        // $productItems = [];

        // foreach ($request->data['data'] as $productData) {
        //     // Pastikan 'value' dan 'id' atau 'product_id' tersedia sebelum mengaksesnya
        //     if (isset($productData['value']['id'])) {
        //         $product = Product::find($productData['value']['id']);
        //     } elseif (isset($productData['value']['product_id'])) {
        //         $product = Product::find($productData['value']['product_id']);
        //     } else {
        //         $product = null; // Jaga-jaga jika 'id' atau 'product_id' tidak ada
        //     }

        //     $quantity = $productData['quantity'];

        //     if ($product && $quantity > 0) {
        //         $itemPrice = $product->price * $quantity;
        //         $totalAmount += $itemPrice;

        //         $productItems[] = [
        //             'product_id' => $product->id,
        //             'quantity' => $quantity,
        //             'price' => $itemPrice,
        //         ];
        //     }
        // }

        // if ($totalAmount > 0) {
        //     $transaction = Transaction::create(['total_amount' => $totalAmount]);

        //     foreach ($productItems as $item) {
        //         TransactionItem::create([
        //             'transaction_id' => $transaction->id,
        //             'product_id' => $item['product_id'],
        //             'quantity' => $item['quantity'],
        //             'price' => $item['price'],
        //         ]);
        //         Product::find($item['product_id'])->decrement('stock', $item['quantity']);
        //     }

        // }

        // testing
        // $string = json_encode($cart);

        // Log::info('ini data :' . $string);

        // return view('pdf.invoiceV1', [
        //     'data' => $data
        // ]);


        // instance mPDF
        $mpdf = new \Mpdf\Mpdf();

        // view sebagai konten PDF
        $html = view('pdf.invoiceV1', $data)->render();

        // Menulis HTML ke dalam PDF
        $mpdf->WriteHTML($html);

        //  nama file unik
        $uniqueFileName = 'invoice_' . date('Y-m-d H:i:s') . '_' . uniqid() . '.pdf';

        // konten PDF sebagai string
        $pdfContent = $mpdf->Output('', 'S');

        // penamaan path pdf invoice
        $timestamp = date('dmy-H-i-s');
        $filePath = '/invoices/invoice-' . $timestamp . '.pdf';

        // log untuk maintenance
        Log::info('Saving PDF to: ' . $filePath);
        Log::info('PDF content type: ' . gettype($pdfContent));
        Log::info('PDF content length: ' . strlen($pdfContent));
            if (Storage::disk('public')->put($filePath, $pdfContent)) {
                Log::info('PDF saved successfully.');
            } else {
                Log::error('Failed to save PDF.');
            }
            Log::info('Attempting to save PDF...');

        // menyimpan pdf di folder invoices
        Storage::disk('public')->put($filePath, $pdfContent);
        Log::info('PDF save attempted.');

        // mengirimkan pdf ke email
        if (file_exists(storage_path('app/public' . $filePath)) && $request->email) {
            // Mengirim email dengan lampiran PDF
            Mail::to($request->email)->send(new SendInvoice(storage_path('app/public' . $filePath)));
            unlink(storage_path('app/public' . $filePath));

            return response()->json([
                'status' => true,
                'message' => 'PDF telah dibuat dan dikirim sebagai: ' . $filePath,
                'data' => $request->all(),
            ], 200);
        } else {
            return 'Error: File PDF tidak dapat disimpan.';
        }
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

    // public function reedemCode(Request $request)
    // {
    //     $code = $request->code;

    //     // Cari semua reedem code berdasarkan kode
    //     $reedemCodes = ReedemCode::where('code', $code)->with('product')->get();

    //     // Cek jika ada data yang ditemukan
    //     if ($reedemCodes->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Kode tidak ditemukan atau tidak ada produk terkait',
    //         ], 404);
    //     }

    //     // Siapkan array untuk menampung produk terkait
    //     $products = [];

    //     // Loop melalui setiap reedem code dan ambil data produk terkait
    //     foreach ($reedemCodes as $reedemCode) {
    //         $products[] = $reedemCode->product;
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil fetch data by code',
    //         'data' => [
    //             'reedem_code' => $reedemCodes, // Mengembalikan semua reedem code terkait
    //             'products' => $products, // Mengembalikan semua produk terkait
    //         ],
    //     ], 200);
    // }

    public function reedemCode(Request $request)
    {
        $code = $request->code;

        // Ambil semua reedem codes berdasarkan kode dan sertakan informasi produk terkait
        $reedemCodes = ReedemCode::where('code', $code)
            ->with('product') // Pastikan relasi 'product' sudah didefinisikan di model ReedemCode
            ->get();

        // Ubah data reedem code agar setiap item juga menyertakan detail produk dan label/value
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
    }





}
