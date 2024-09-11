<?php

namespace App\Models;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    protected $fillable = ['total_amount'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
