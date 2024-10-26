<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaymentCode;
use Carbon\Carbon;

class UpdatePendingStatus extends Command
{
    protected $signature = 'status:update-pending';
    protected $description = 'Update all pending statuses to failed after 10 minutes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $transactions = Transaction::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(10))
            ->get();

        // Loop untuk setiap transaksi dan lakukan perubahan
        foreach ($transactions as $transaction) {
            // Ubah status transaksi menjadi 'failed'
            $transaction->update(['status' => 'failed']);

            // Hapus kode pembayaran yang terkait dengan transaksi ini
            PaymentCode::where('transaction_id', $transaction->id)->delete();
        }
    }
}
