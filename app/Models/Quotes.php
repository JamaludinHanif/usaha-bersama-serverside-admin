<?php

namespace App\Models;

use App\Models\User;
use App\Models\Quotes;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotes extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


// Quotes::create([
//     'category_id' => 1,
//     'user_id' => 1,
//     'title' => 'Kamu mau bunga ??',
//     'quote' => '<p>jika kamu mau bunga pada 14 februari</p><p>meninggal lah pada 13 februari</p>'
// ]);
// Quotes::create([
//     'category_id' => 2,
//     'user_id' => 1,
//     'title' => 'Kamu membawa hatiku bersamamu',
//     'quote' => 'Kamu membawa hatiku bersamamu. Selama kamu bersamaku, aku tidak perlu takut, karena aku tahu hatiku aman bersamamu'
// ]);
