<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoice;
use App\Models\Cart;
use App\Models\InterestBill;
use App\Models\LogActivity;
use App\Models\Paylater;
use App\Models\PaymentCode;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\MyClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
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
    // public function checkOutV1(Request $request)
    // {

    //     return $request->all();

    //     $formattedDate = now()->format('dmy:s');
    //     $noInvoice = 'INV-' . $formattedDate . '-' . $request->userId;

    //     // database section
    //     $totalAmount = 0;
    //     $productItems = [];

    //     foreach ($request->data as $productData) {
    //         // Pastikan 'value' dan 'id' atau 'product_id' tersedia sebelum mengaksesnya
    //         if (isset($productData['value']['id'])) {
    //             $product = Product::find($productData['value']['id']);
    //         } elseif (isset($productData['value']['product_id'])) {
    //             $product = Product::find($productData['value']['product_id']);
    //         } else {
    //             $product = null; // Jaga-jaga jika 'id' atau 'product_id' tidak ada
    //         }

    //         $quantity = $productData['quantity'];

    //         if ($product && $quantity > 0) {
    //             $itemPrice = $product->price * $quantity;
    //             $totalAmount += $itemPrice;

    //             $productItems[] = [
    //                 'product_id' => $product->id,
    //                 'quantity' => $quantity,
    //                 'price' => $itemPrice,
    //             ];
    //         }
    //     }

    //     if ($totalAmount > 0) {
    //         $transaction = Transaction::create([
    //             'total_amount' => $totalAmount,
    //             'kode_invoice' => $noInvoice,
    //             'user_id' => $request->userId,
    //             'type' => $request->methodPayment,
    //             'status' => 'pending',
    //             'interest_id' => $request->interestId,
    //         ]);

    //         foreach ($productItems as $item) {
    //             TransactionItem::create([
    //                 'transaction_id' => $transaction->id,
    //                 'user_id' => $request->userId,
    //                 'product_id' => $item['product_id'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //             ]);
    //             Product::find($item['product_id'])->decrement('stock', $item['quantity']);
    //         }

    //         // make code payment
    //         do {
    //             $uniqueCode = Str::upper(Str::random(8)); // membuat kode acak
    //         } while (PaymentCode::where('code', $uniqueCode)->exists());

    //         if ($request->methodPayment == "paylater") {
    //             PaymentCode::create([
    //                 'transaction_id' => $transaction->id,
    //                 'user_id' => $request->userId,
    //                 'code' => $uniqueCode,
    //                 'type' => $request->methodPayment,
    //                 'type_sending' => $request->methodSending,
    //                 'status' => "pending",
    //                 'new_purchase' => true,
    //                 'amount' => 0,
    //                 'cashier_id' => null,
    //                 'interest_id' => $request->interestId,
    //             ]);
    //         } else {
    //             PaymentCode::create([
    //                 'transaction_id' => $transaction->id,
    //                 'user_id' => $request->userId,
    //                 'code' => $uniqueCode,
    //                 'type' => $request->methodPayment,
    //                 'type_sending' => $request->methodSending,
    //                 'status' => "pending",
    //                 'new_purchase' => true,
    //                 'amount' => $totalAmount,
    //                 'cashier_id' => null,
    //                 'interest_id' => null,
    //             ]);
    //         }

    //         // log activity
    //         LogActivity::create([
    //             'user_id' => $request->userId,
    //             'action' => 'melakukan pembelian',
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Generate Kode Pembayaran Berhasil',
    //             'code' => $uniqueCode,
    //             'data' => $request->all(),
    //         ], 200);
    //     }
    // }

    public function paymentCashier(Request $request)
    {

        $formattedDate = now()->format('dmy-s');
        $noInvoice = 'INV-' . $formattedDate . '-' . $request->userId;

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
                'user_id' => $request->userId,
                'status' => 'success',
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

            // log activity
            LogActivity::create([
                'user_id' => $request->userId,
                'action' => 'melakukan pembelian',
            ]);

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

        if ($data->new_purchase = 1) {
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
        } else {
            return response()->json([
                'status' => true,
                'message' => 'get data transaksi succes',
                'userData' => $userData,
                'totalHargaBarang' => $totalAmount->total_amount,
                'data' => $data,
                'dataProduct' => $dataProduct,
            ], 200);
        }
    }

    public function confirmPayment(Request $request)
    {
        DB::beginTransaction();
        try {
            $myClass = new MyClass();

            // Ambil data terkait
            $data = PaymentCode::where('code', $request->code)->firstOrFail();
            $dataTransaction = Transaction::findOrFail($data->transaction_id);
            $dataProduct = TransactionItem::where('transaction_id', $data->transaction_id)->with('product')->get();
            $userData = User::findOrFail($data->user_id);
            $dataPaylater = Paylater::find($data->paylater_id);
            $dataBunga = $data->interest_id ? InterestBill::find($data->interest_id) : null;

            $paymentType = '';
            $html = '';
            $dataPdf = [];

            if ($data->new_purchase == 1) {
                if ($data->type == "paylater") {
                    $paymentType = "Pembelian Paylater";
                    $jatuhTempo = $dataBunga->unit_date == "hari"
                    ? Carbon::now()->addDays($dataBunga->amount_day)
                    : Carbon::now()->addWeeks($dataBunga->amount_day);
                    $totalTagihan = $dataTransaction->total_amount + ($dataTransaction->total_amount * ($dataBunga->interest / 100));

                    Paylater::create([
                        'debt_remaining' => $totalTagihan,
                        'user_id' => $data->user_id,
                        'transaction_id' => $dataTransaction->id,
                        'interest_id' => $dataBunga->id,
                        'status' => "1",
                        'due_date' => $jatuhTempo,
                    ]);

                    $dataPdf = [
                        'noInvoice' => $dataTransaction->kode_invoice,
                        'name' => $userData->name,
                        'dataProduk' => $dataProduct,
                        'totalHarga' => $dataTransaction->total_amount,
                        'dataBunga' => $dataBunga,
                    ];

                    $html = view('pdf.invoice-pembelian.invoicePaylater', $dataPdf)->render();
                } elseif ($data->type == "cash") {
                    $paymentType = "Pembayaran Cash";

                    $dataPdf = [
                        'noInvoice' => $dataTransaction->kode_invoice,
                        'name' => $userData->name,
                        'dataProduk' => $dataProduct,
                        'totalHarga' => $dataTransaction->total_amount,
                    ];

                    $html = view('pdf.invoice-pembelian.invoiceCash', $dataPdf)->render();
                }
            } else {
                $paymentType = "Pembayaran Tagihan";

                $dataPdf = [
                    'noInvoice' => $dataTransaction->kode_invoice,
                    'name' => $userData->name,
                    'nominalPembayaran' => $data->amount,
                    'dataPaylater' => $dataPaylater,
                ];

                $html = view('pdf.invoice-pembelian.invoicePembayaranTagihan', $dataPdf)->render();
                $dataPaylater->decrement('debt_remaining', $data->amount);
            }

            $data->update(['status' => "success", 'cashier_id' => $request->cashier_id]);
            $dataTransaction->update(['status' => 'success']);

            // Generate PDF
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $filePath = '/invoices/invoice-' . now()->format('dmy-H-i-s') . '.pdf';
            $pdfContent = $mpdf->Output('', 'S');

            Storage::disk('public')->put($filePath, $pdfContent);

            LogActivity::create([
                'user_id' => $request->cashier_id,
                'action' => 'Konfirmasi Pembayaran ' . $data->transaction_id,
            ]);

            if ($data->type_sending == 'email') {
                Mail::to($userData->email)->send(new SendInvoice(storage_path('app/public' . $filePath)));
                unlink(storage_path('app/public' . $filePath));
            } elseif ($data->type_sending == 'whatsapp') {
                $myClass->sendMessageWhatsapp($userData->no_hp, url('storage' . $filePath), "Berikut adalah Invoice pembelian anda");
                unlink(storage_path('app/public' . $filePath));
            } else {
                Mail::to($userData->email)->send(new SendInvoice(storage_path('app/public' . $filePath)));
                $myClass->sendMessageWhatsapp($userData->no_hp, url('storage' . $filePath), "Berikut adalah Invoice pembelian anda");
                unlink(storage_path('app/public' . $filePath));
            }

            DB::commit();
            return response()->json(['success' => 'Konfirmasi pembayaran berhasil'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan', 'details' => $e->getMessage()], 500);
        }
    }

    public function cekStatusPayment(Request $request)
    {
        $data = PaymentCode::where('code', $request->code)->first();

        if ($data->status == "success") {
            return response()->json([
                'status' => true,
                'message' => "pembayaran berhasil",
                'data' => $data->status,
            ], 200);
        } else if ($data->status == "pending") {
            return response()->json([
                'status' => true,
                'message' => "menunggu konfirmasi dari kasir",
                'data' => $data->status,
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => "pembayaran gagal silahkan checkout ulang",
                'data' => $data->status,
            ], 200);
        }
    }

    // seller
    public function preCheckout(Request $request)
    {
        if ($request->product) {
            $data = Product::where('slug', $request->product)->get()->map(function ($item) {
                return [
                    'product' => $item,
                    'quantity' => 1,
                ];
            });
            return view('buyer.preCheckout', [
                'title' => 'PreCheckout',
                'datas' => $data,
            ]);
        } else {
            $cart = Cart::where('user_id', session('userData')->id)
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'product' => $item->product,
                        'quantity' => $item->quantity,
                    ];
                });
            return view('buyer.preCheckout', [
                'title' => 'PreCheckout',
                'datas' => $cart,
            ]);
        }
    }

    public function checkoutBuyer(Request $request)
    {
        $request->validate([
            'seller_id' => 'required',
        ], [
            'seller_id.required' => 'Toko pembelian wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            // database section

            // Buat kode invoice baru
            do {
                $randomLetters = Str::upper(Str::random(4));
                $date = now()->format('dmy');
                $codeInvoice = $randomLetters . "-" . $date . "-" . session('userData')->id;

                $exists = \App\Models\Transaction::where('code_invoice', $codeInvoice)->exists();
            } while ($exists);

            $totalAmount = 0;
            $productItems = [];

            foreach ($request->data as $productData) {
                // Pastikan 'value' dan 'id' atau 'product_id' tersedia sebelum mengaksesnya
                if (isset($productData['product_id'])) {
                    $product = Product::find($productData['product_id']);
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
                    'amount' => $totalAmount,
                    'code_invoice' => $codeInvoice,
                    'user_id' => session('userData')->id,
                    'status' => 'pending',
                    'seller_id' => $request->seller_id,
                ]);

                foreach ($productItems as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'user_id' => session('userData')->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                    Product::find($item['product_id'])->decrement('stock', $item['quantity']);
                }

                // log activity
                LogActivity::create([
                    'user_id' => session('userData')->id,
                    'action' => 'melakukan transaksi',
                ]);

                //
                if (count($request->data) > 1) {
                    Cart::where('user_id', session('userData')->id)->delete();
                }
                DB::commit();
                return response()->json(['message' => 'Transaksi Berhasil', 'data' => $request->all()], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Pendaftaran gagal. Silakan coba lagi.', 'details' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}"], 500);
        }
    }

    // seller
    public function confirmOrder(Request $request)
    {
        // Validasi request
        $request->validate([
            'id' => 'required|integer|exists:transactions,id',
        ]);

        DB::beginTransaction();
        try {
            // Ambil data transaksi
            $transaction = Transaction::with('user', 'seller')->findOrFail($request->id);
            $transaction->update(['status' => 'success']);

            // Ambil data user dan item transaksi
            $userData = $transaction->user;
            $dataProduct = TransactionItem::with('product')->where('transaction_id', $transaction->id)->get();

            // Siapkan data untuk PDF
            $dataPdf = [
                'noInvoice' => $transaction->code_invoice,
                'name' => $userData->name,
                'dataProduk' => $dataProduct,
                'totalHarga' => $transaction->amount,
            ];

            $html = view('pdf.invoice-pembelian.invoiceCash', $dataPdf)->render();

            // Generate PDF
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $fileName = 'invoice-' . now()->format('dmy-H-i-s') . '.pdf';
            $filePath = 'invoices/' . $fileName;
            $pdfContent = $mpdf->Output('', 'S');

            // Simpan PDF ke storage
            Storage::disk('public')->put($filePath, $pdfContent);

            // Kirim email dengan file PDF
            Mail::to($userData->email)->send(new SendInvoice(storage_path('app/public/' . $filePath)));

            // Hapus file PDF dari storage setelah email terkirim
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Log aktivitas
            LogActivity::create([
                'user_id' => 15,
                'action' => "Konfirmasi pembayaran ($transaction->code_invoice), kasir " . ($transaction->seller->shop_name ?? 'Tanpa Nama'),
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Konfirmasi Pesanan Berhasil',
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Logging error untuk debugging
            Log::error("Error Konfirmasi Pesanan: {$e->getMessage()}", [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => 'Konfirmasi Pesanan gagal. Silakan coba lagi.',
                'details' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}",
            ], 500);
        }
    }


    public function checkoutSeller(Request $request)
    {
        DB::beginTransaction();
        try {
            // database section

            do {
                $randomLetters = Str::upper(Str::random(4));
                $date = now()->format('dmy');
                $codeInvoice = $randomLetters . "-" . $date . "-" . session('userData')->id;

                $exists = \App\Models\Transaction::where('code_invoice', $codeInvoice)->exists();
            } while ($exists);

            $totalAmount = 0;
            $productItems = [];

            foreach ($request->data as $productData) {
                if (isset($productData['product_id'])) {
                    $product = Product::find($productData['product_id']);
                } else {
                    $product = null;
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
                    'amount' => $totalAmount,
                    'code_invoice' => $codeInvoice,
                    'user_id' => 15,
                    'status' => 'success',
                    'seller_id' => session('userData')->id,
                ]);

                foreach ($productItems as $item) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'user_id' => 15,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                    Product::find($item['product_id'])->decrement('stock', $item['quantity']);
                }

            // Ambil data user dan item transaksi
            $userData = $transaction->user;
            $dataProduct = TransactionItem::with('product')->where('transaction_id', $transaction->id)->get();

            // Siapkan data untuk PDF
            $dataPdf = [
                'noInvoice' => $transaction->code_invoice,
                'name' => $userData->name,
                'dataProduk' => $dataProduct,
                'totalHarga' => $transaction->amount,
            ];

            $html = view('pdf.invoice-pembelian.invoiceCash', $dataPdf)->render();

            // Generate PDF
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $fileName = 'invoice-' . now()->format('dmy-H-i-s') . '.pdf';
            $filePath = 'invoices/' . $fileName;
            $pdfContent = $mpdf->Output('', 'S');

            // Simpan PDF ke storage
            Storage::disk('public')->put($filePath, $pdfContent);

            // Kirim email dengan file PDF
            Mail::to('newhanif743@gmail.com')->send(new SendInvoice(storage_path('app/public/' . $filePath)));

            // Hapus file PDF dari storage setelah email terkirim
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

                // log activity
                LogActivity::create([
                    'user_id' => 15,
                    'action' => "melakukan transaksi via kasir " . session('userData')->shop_name,
                ]);

                DB::commit();
                return response()->json(['message' => 'Transaksi Berhasil', 'data' => $request->all()], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Pendaftaran gagal. Silakan coba lagi.', 'details' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}"], 500);
        }
    }
}
