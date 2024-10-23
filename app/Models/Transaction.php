<?php

namespace App\Models;

use App\Models\Paylater;
use App\Models\PaymentCode;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    protected $fillable = ['total_amount', 'user_id', 'kode_invoice', 'type', 'status'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function paymentCode()
    {
        return $this->hasOne(PaymentCode::class);
    }

    public function paylater()
    {
        return $this->hasOne(Paylater::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
