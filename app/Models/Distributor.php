<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keterangan',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
