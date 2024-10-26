<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoice;
use App\Models\InterestBill;
use App\Models\PaymentCode;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{

    // admin
    public function showAll()
    {
        return view('admin-transaction.transaction', [
            'title' => 'History Transaksi',
            'datas' => Transaction::all(),
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
            ->addColumn('action', function ($data) {
                return view('admin-transaction.action')->with('data', $data);
            })
            ->addColumn('formatted_amount', function ($row) {
                return $row->total_amount ? 'Rp ' . number_format($row->total_amount, 0, ',', '.') : '';
            })
            ->rawColumns(['action', 'username', 'formatted_amount', 'formatted_created_at'])
            ->make(true);
    }

    // untuk memformat nomor agar 62087xxx
    public static function idPhoneNumberFormat($phone)
    {
        $output = $phone;
        $output = substr($output, 0, 1) == '0' ? "62" . substr($output, 1) : $output;
        $output = substr($output, 0, 3) == '+62' ? substr($output, 1) : $output;
        $output = substr($output, 0, 2) != '62' ? "62" . $output : $output;

        return $output;
    }

    // api user
    public function checkOutV1(Request $request)
    {

        $formattedDate = now()->format('dmy:s');
        $noInvoice = 'INV-' . $formattedDate . '-' . $request->userId;

        // database section
        $totalAmount = 0;
        $productItems = [];

        foreach ($request->data as $productData) {
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
                'user_id' => $request->userId,
                'type' => $request->methodPayment,
                'status' => 'pending',
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

            // make code payment
            do {
                $uniqueCode = Str::upper(Str::random(8)); // membuat kode acak
            } while (PaymentCode::where('code', $uniqueCode)->exists());

            if ($request->methodPayment == "paylater") {
                PaymentCode::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => $request->userId,
                    'code' => $uniqueCode,
                    'type' => $request->methodPayment,
                    'type_sending' => $request->methodSending,
                    'status' => "pending",
                    'amount' => 0,
                    'cashier_id' => null,
                    'interest_id' => $request->interest_id,
                ]);
            } else {
                PaymentCode::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => $request->userId,
                    'code' => $uniqueCode,
                    'type' => $request->methodPayment,
                    'type_sending' => $request->methodSending,
                    'status' => "pending",
                    'amount' => $totalAmount,
                    'cashier_id' => null,
                    'interest_id' => null,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Generate Kode Pembayaran Berhasil',
                'code' => $uniqueCode,
                'data' => $request->all(),
            ], 200);
        }
    }

    public function getDataTransactionForCashier(Request $request)
    {
        $data = PaymentCode::where('code', $request->code)->first();

        $dataProduct = TransactionItem::where('transaction_id', $data->transaction_id)->with('product')->get();
        $totalAmount = Transaction::where('id', $data->transaction_id)->select('total_amount')->first();

        $userData = User::where('id', $data->user_id)->first();

        return response()->json([
            'status' => true,
            'message' => 'get data transaksi succes',
            'userData' => $userData,
            'totalHargaBarang' => $totalAmount->total_amount,
            'data' => $data,
            'dataProduct' => $dataProduct,
        ], 200);
    }

    public function confirmPayment(Request $request)
    {

        $data = PaymentCode::where('code', $request->code)->first();

        $dataProduct = TransactionItem::where('transaction_id', $data->transaction_id)->with('product')->get();
        $dataTransaction = Transaction::where('id', $data->transaction_id)->first();
        $dataBunga = InterestBill::where('id', $data->interest_id)->first();

        $userData = User::where('id', $data->user_id)->first();

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Konfirmasi Pembayaran Berhasil',
        //     'userData' => $userData,
        //     'totalHargaBarang' => $dataTransaction,
        //     'data' => $data->type_sending,
        //     'dataProduct' => $dataProduct,
        //     'cashier_id' => $request->cashier_id,
        //     'dataBunga' => $dataBunga,
        // ], 200);

        $dataPdf = [
            'name' => $userData->name,
            'dataProduk' => $dataProduct,
            'totalHarga' => $dataTransaction->total_amount,
            'dataBunga' => $dataBunga,
            'noInvoice' => $dataTransaction->kode_invoice,
        ];

        // testing
        // $string = json_encode($cart);

        // Log::info('ini data :' . $string);

        // return view('pdf.invoiceV1', [
        //     'data' => $data
        // ]);

        // instance mPDF
        $mpdf = new \Mpdf\Mpdf();

        // view sebagai konten PDF
        $html = view('pdf.invoiceV1', $dataPdf)->render();

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

        $data->update([
            'status' => "success",
            'cashier_id' => $request->cashier_id,
        ]);

        $dataTransaction->update([
            'status' => 'success',
        ]);

        // mengirimkan pdf
        if (file_exists(storage_path('app/public' . $filePath))) {
            if ($data->type_sending == 'email') {
                // Mengirim email dengan lampiran PDF
                Mail::to($userData->email)->send(new SendInvoice(storage_path('app/public' . $filePath)));

                unlink(storage_path('app/public' . $filePath));

                return response()->json([
                    'status' => true,
                    'message' => 'PDF telah dibuat dan dikirim sebagai: ' . $filePath,
                    'data' => $request->all(),
                ], 200);
            } else if ($data->type_sending == 'whatsapp') {
                // mengirim via whatsapp
                $body = [
                    "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
                    "sender" => "6285161310017",
                    "number" => $userData->no_hp,
                    "media_type" => "document",
                    "caption" => "Berikut adalah Invoice pembelian anda",
                    "url" => url('storage' . $filePath),
                ];
                $responseApiWa = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://wa.sinkron.com/send-media', $body);

                unlink(storage_path('app/public' . $filePath));

                return response()->json([
                    'status' => true,
                    'message' => 'PDF telah dibuat dan dikirim sebagai: ' . $filePath,
                    'responApiWa' => $responseApiWa->json(),
                    'body' => $body,
                    'method' => $request->methodSending,
                    'data' => $request->all(),
                ], 200);
            } else {
                $body = [
                    "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
                    "sender" => "6285161310017",
                    "number" => "6285161310017",
                    "media_type" => "document",
                    "caption" => "Berikut adalah Invoice pembelian anda",
                    "url" => url('storage' . $filePath),
                ];
                $responseApiWa = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post('https://wa.sinkron.com/send-media', $body);

                // Mengirim email dengan lampiran PDF
                Mail::to($userData->email)->send(new SendInvoice(storage_path('app/public' . $filePath)));

                unlink(storage_path('app/public' . $filePath));

                return response()->json([
                    'status' => true,
                    'message' => 'PDF telah dibuat dan dikirim sebagai: ' . $filePath,
                    'responApiWa' => $responseApiWa->json(),
                    'data' => $request->all(),
                ], 200);
            }
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
