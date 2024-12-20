<?php

namespace App\Models;

use App\Models\User;
use App\Models\Paylater;
use App\Models\Transaction;
use App\Models\InterestBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'status',
        'amount',
        'type_sending',
        'new_purchase',
        // 'path_invoice',
        'transaction_id',
        'user_id',
        'cashier_id',
        'interest_id',
        'paylater_id'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interest(){
        return $this->belongsTo(InterestBill::class);
    }

    public function paylater(){
        return $this->belongsTo(Paylater::class);
    }
}
