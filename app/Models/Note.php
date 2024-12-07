<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'user_id',
        'status', // 1 artinya belum selesai sedangkan 2 artinya selesai
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

