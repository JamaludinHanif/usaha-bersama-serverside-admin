<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes; // Tambahkan SoftDeletes trait

    // Kolom-kolom yang dapat diisi
    protected $fillable = [
        'name',
        'price',
        'unit',
        'category',
        'image',
        'stock',
        'expired_date'
    ];

}


// Product::create([
//     'name' => 'nabati ukuran 720g rasa coklat',
//     'price' => 2500,
//     'unit' => 'pcs',
//     'category' => 'makanan',
//     'image' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//105/MTA-27188906/nabati_wafer_nabati_50gr_-_coklat_rischeese-keju_full01_5d98abe1.jpg',
//     'stock' => 24
// ])

// Product::create([
//     'name' => 'Teh gelas cup kecil ukuran 200ml',
//     'price' => 1000,
//     'unit' => 'pcs',
//     'category' => 'minuman',
//     'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnYOSy866mSQji7p8HVPMIwKfdoC732z5rMg&s',
//     'stock' => 100
// ])

// Product::create([
//     'name' => 'Teh gelas cup kecil isi 24',
//     'price' => 23000,
//     'unit' => 'dos',
//     'category' => 'minuman',
//     'image' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98v-ltd9jl2olv6v94',
//     'stock' => 5
// ])

// Product::create([
//     'name' => 'rinso cair saset ukuran 10gram',
//     'price' => 1000,
//     'unit' => 'pcs',
//     'category' => 'pembersih',
//     'image' => 'https://images.tokopedia.net/img/cache/700/product-1/2020/9/28/14677532/14677532_50d6da2c-00e5-487e-8e2d-1c72b2144532_800_800',
//     'stock' => 100
// ])

// Product::create([
//     'name' => 'nabati all variant ukuran 16gram',
//     'price' => 1000,
//     'unit' => 'pack',
//     'category' => 'makanan',
//     'image' => 'https://down-id.img.susercontent.com/file/9897f81c8d6415e5f207ced234927e57',
//     'stock' => 20
// ])
