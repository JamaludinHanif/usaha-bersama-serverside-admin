<?php

namespace App\Models;

use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock'];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
