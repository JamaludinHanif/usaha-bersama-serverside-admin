<?php

namespace App\Models;

use App\Models\Quotes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function quote()
    {
        return $this->hasMany(Quotes::class);
    }
}

// Category::create([
//     'name' => 'kata-kata by kak Gem',
// ]);

// Category::create([
//     'name' => 'Romantis',
// ]);
