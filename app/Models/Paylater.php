<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use App\Models\InterestBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paylater extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_remaining',
        'transaction_id',
        'user_id',
        'interest_id',
        'status', // 1 artinya belum lunas sedangkan 2 artinya lunas
        'due_date',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interest()
    {
        return $this->belongsTo(InterestBill::class);
    }
}
