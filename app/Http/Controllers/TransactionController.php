<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Mail\SendInvoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    // admin
    public function showAll()
    {
        return view('admin-transaction.transaction', [
            'title' => 'History Transaksi',
            'datas' => Transaction::all()
        ]);
    }

    public function showDataJsonAdmin(Request $request)
    {
        $data = Transaction::query();

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }

        // search datatables sistem *(jika search defaultnya error)
        // if ($request->has('search') && $request->search['value'] != '') {
        //     $searchValue = $request->search['value'];
        //     $data->where(function($query) use ($searchValue) {
        //         $query->whereHas('user', function($query) use ($searchValue) {
        //                 $query->where('kode_invoice', 'like', "%{$searchValue}%")
        //                       ->orWhere('username', 'like', "%{$searchValue}%")
        //                       ->orWhere('total_amount', 'like', "%{$searchValue}%");
        //             })
        //             ->orWhere('created_at', 'like', "%{$searchValue}%")
        //             ->orWhere('action', 'like', "%{$searchValue}%");
        //     });
        // }

        return Datatables::of($data)
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : '';
            })
            ->addColumn('formatted_created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y H:i:s') : '';
            })
            ->addColumn('action', function($data){
                return view('admin-transaction.action')->with('data', $data);
            })
            ->addColumn('formatted_amount', function($row) {
                return $row->total_amount ? 'Rp ' . number_format($row->total_amount, 0, ',', '.') : '';
            })
            ->rawColumns(['action', 'username', 'formatted_amount', 'formatted_created_at'])
            ->make(true);
    }

    // api user
    public function checkOutV1(Request $request)
    {
        $formattedDate = now()->format('dmy:s');
        $noInvoice = 'INV-' . $formattedDate . '-' . $request->userId;

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

        // database section
        $totalAmount = 0;
        $productItems = [];

        foreach ($request->data['data'] as $productData) {
            // Pastikan 'value' dan 'id' atau 'product_id' tersedia sebelum mengaksesnya
            if (isset($productData['value']['id'])) {
                $product = Product::find($productData['value']['id']);
            } elseif (isset($productData['value']['product_id'])) {
                $product = Product::find($productData['value']['product_id']);
            } else {
                $product = null; // Jaga-jaga jika 'id' atau 'product_id' tidak ada
            }

            $quantity = $productData['quantity'];

            if ($product && $quantity > 0) {
                $itemPrice = $product->price * $quantity;
                $totalAmount += $itemPrice;

                $productItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $itemPrice,
                ];
            }
        }

        if ($totalAmount > 0) {
            $transaction = Transaction::create([
                                'total_amount' => $totalAmount,
                                'kode_invoice' => $noInvoice,
                                'user_id' => $request->userId
                            ]);

            foreach ($productItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => $request->userId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                Product::find($item['product_id'])->decrement('stock', $item['quantity']);
            }

        }

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

    public function preCheckout(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Load berhasil',
            'data' => $request->all(),
        ], 200);
    }
}
