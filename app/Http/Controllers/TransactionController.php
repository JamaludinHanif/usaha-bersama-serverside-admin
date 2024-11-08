<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoice;
use App\Models\InterestBill;
use App\Models\Paylater;
use App\Models\PaymentCode;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    // api whatsapp
    public function curlApiWhatsapp($urlApiWhatsapp, $body)
    {
        // Inisialisasi cURL
        $ch = curl_init();

        // Mengatur opsi cURL
        curl_setopt($ch, CURLOPT_URL, $urlApiWhatsapp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout 10 detik
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        // Eksekusi cURL dan ambil respons
        $response = curl_exec($ch);
        $error = curl_error($ch);

        // Tutup koneksi cURL
        curl_close($ch);

        // Cek apakah ada error
        if ($error) {
            return "cURL Error: " . $error;
        }

        return $response;
    }

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
                return $row->created_at ? $row->created_at->format('d-m-Y (H:i:s)') : '';
            })
            ->addColumn('action', function ($data) {
                return view('admin-transaction.action')->with('data', $data);
            })
            ->addColumn('formatted_amount', function ($row) {
                return $row->total_amount ? 'Rp ' . number_format($row->total_amount, 0, ',', '.') : '';
            })
            ->addColumn('status_formatted', function ($row) {
                $btnClass = $row->status == 'success' ? 'btn-success' : ($row->status == 'pending' ? 'btn-warning' : 'btn-danger');
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $row->status . '</span>
                    </div></center>';
            })
            ->rawColumns(['action', 'username', 'status_formatted', 'formatted_amount', 'formatted_created_at'])
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
                'interest_id' => $request->interestId,
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
                    'new_purchase' => true,
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
                    'new_purchase' => true,
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

        $data = PaymentCode::where('code', $request->code)->first();
        $dataProduct = TransactionItem::where('transaction_id', $data->transaction_id)->with('product')->get();
        $dataTransaction = Transaction::where('id', $data->transaction_id)->first();
        $userData = User::where('id', $data->user_id)->first();
        $dataPaylater = Paylater::where('id', $data->paylater_id)->first();
        if (isset($data->interest_id)) {
            $dataBunga = InterestBill::where('id', $data->interest_id)->first();
        };
        $paymentType = [];

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Konfirmasi Pembayaran Berhasil',
        //     'userData' => $userData,
        //     'totalHargaBarang' => $dataTransaction,
        //     'data' => $data,
        //     'dataProduct' => $dataProduct,
        //     'cashier_id' => $request->cashier_id,
        //     'dataPaylater' => $dataPaylater,
        //     // 'dataBunga' => $dataBunga,
        //     // 'totalTagihan' => $totalHargaTagihanPaylater,
        //     // 'jatuhTempo' => $jatuhTempo,
        // ], 200);

        if ($data->new_purchase == 1) {
            if ($data->type == "paylater") {
                $paymentType = "Pembelian Paylater";
                if ($dataBunga->unit_date == "hari") {
                    $jatuhTempo = Carbon::now()->addDays($dataBunga->amount_day);
                } else {
                    $jatuhTempo = Carbon::now()->addWeeks($dataBunga->amount_day);
                }
                $totalHargaTagihanPaylater = $dataTransaction->total_amount + ($dataTransaction->total_amount * ($dataBunga->interest / 100));
                Paylater::create([
                    'debt_remaining' => $totalHargaTagihanPaylater,
                    'user_id' => $data->user_id,
                    'transaction_id' => $dataTransaction->id,
                    'interest_id' => $dataBunga->id,
                    'status' => "1", // 1 artinya belum lunas sedangkan 2 artinya lunas
                    'due_date' => $jatuhTempo,
                ]);
                $data->update([
                    'status' => "success",
                    'cashier_id' => $request->cashier_id,
                ]);

                $dataTransaction->update([
                    'status' => 'success',
                ]);

                $dataPdf = [
                    'noInvoice' => $dataTransaction->kode_invoice,
                    'name' => $userData->name,
                    // pembelian baru
                    'dataProduk' => $dataProduct,
                    'totalHarga' => $dataTransaction->total_amount,
                    'dataBunga' => $dataBunga,
                ];

                // instance mPDF
                $mpdf = new \Mpdf\Mpdf();
                // view sebagai konten PDF
                $html = view('pdf.invoice-pembelian.invoicePaylater', $dataPdf)->render();
            } else if ($data->type == "tunai") {
                // dd($data->type);
                $paymentType = "Pembayaran Cash";
                $data->update([
                    'status' => "success",
                    'cashier_id' => $request->cashier_id,
                ]);

                $dataTransaction->update([
                    'status' => 'success',
                ]);

                $dataPdf = [
                    'noInvoice' => $dataTransaction->kode_invoice,
                    'name' => $userData->name,
                    // pembelian baru
                    'dataProduk' => $dataProduct,
                    'totalHarga' => $dataTransaction->total_amount,
                ];
                // instance mPDF
                $mpdf = new \Mpdf\Mpdf();
                // view sebagai konten PDF
                $html = view('pdf.invoice-pembelian.invoiceCash', $dataPdf)->render();
            } else {
                $data->update([
                    'status' => "failed",
                    'cashier_id' => $request->cashier_id,
                ]);

                $dataTransaction->update([
                    'status' => 'failed',
                ]);
            }
        } else {
            $paymentType = "Pembayaran Tagihan";
            $data->update([
                'status' => "success",
                'cashier_id' => $request->cashier_id,
            ]);

            $dataPaylater->decrement('debt_remaining', $data->amount);

            $dataTransaction->update([
                'status' => 'success',
            ]);

            $dataPdf = [
                'noInvoice' => $dataTransaction->kode_invoice,
                'name' => $userData->name,
                // pembayaran tagihan
                'nominalPembayaran' => $data->amount,
                'dataPaylater' => $dataPaylater,
            ];

            // instance mPDF
            $mpdf = new \Mpdf\Mpdf();
            // view sebagai konten PDF
            $html = view('pdf.invoice-pembelian.invoicePembayaranTagihan', $dataPdf)->render();
        }

        // $dataPdf = [
        //     'noInvoice' => $dataTransaction->kode_invoice,
        //     'name' => $userData->name,
        //     'paymentType' => $paymentType,
        //     'newPurchase' => $data->new_purchase,
        //     // pembelian baru
        //     'dataProduk' => $dataProduct,
        //     'totalHarga' => $dataTransaction->total_amount,
        //     'dataBunga' => $dataBunga ?? 0,
        //     // pembayaran tagihan
        //     'nominalPembayaran' => $data->amount,
        //     'dataPaylater' => $dataPaylater,
        // ];

        // testing
        // $string = json_encode($cart);

        // Log::info('ini data :' . $string);

        // return view('pdf.invoiceV1', [
        //     'data' => $data
        // ]);

        // mpdf intance
        // Menulis HTML ke dalam PDF
        $mpdf->WriteHTML($html);

        //  nama file unik
        $uniqueFileName = 'invoice_' . date('Y-m-d') . '_' . uniqid() . '.pdf';

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

        // mengirimkan pdf
        if (file_exists(storage_path('app/public' . $filePath))) {
            $urlApiWhatsapp = "https://0443-103-242-107-171.ngrok-free.app/send";
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
                    // "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
                    // "sender" => "6285161310017",
                    // "media_type" => "document",
                    // "url" => url('storage' . $filePath),
                    "number" => $userData->no_hp,
                    "fileUrl" => url('storage' . $filePath),
                    "caption" => "Berikut adalah Invoice pembelian anda",
                ];
                $responseApiWa = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(60)
                    ->post('https://a329-103-242-107-171.ngrok-free.app/send', $body);

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
                    // "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
                    // "sender" => "6285161310017",
                    // "media_type" => "document",
                    // "url" => url('storage' . $filePath),
                    "fileUrl" => url('storage' . $filePath),
                    "number" => "6285161310017",
                    "caption" => "Berikut adalah Invoice pembelian anda",
                ];
                // Mengonversi array ke JSON
                $jsonBody = json_encode($body);
                $responseApiWa = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($urlApiWhatsapp, $jsonBody);

                // $responseApiWa = $this->curlApiWhatsapp($urlApiWhatsapp, $body);

                // Log respons untuk debugging
                \Log::info('Respons dari server:', [
                    'status' => $responseApiWa->status(),
                    'body' => $responseApiWa->body(),
                ]);

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

    public function preCheckout(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Load berhasil',
            'data' => $request->all(),
        ], 200);
    }

// // Contoh penggunaan fungsi
// $url = 'https://a329-103-242-107-171.ngrok-free.app/send';
// $data = [
//     'number' => '6285161310017',
//     'caption' => 'Berikut adalah Invoice pembelian anda',
// ];

// $response = sendCurlRequest($url, $data);
// echo $response;

}
