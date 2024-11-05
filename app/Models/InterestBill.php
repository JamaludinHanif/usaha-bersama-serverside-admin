<?php

namespace App\Models;

use App\Models\Paylater;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InterestBill extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'interest',
        'amount_day',
        'unit_date',
    ];

    protected $dates = ['deleted_at'];

    public function paylater()
    {
        return $this->hasMany(Paylater::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
