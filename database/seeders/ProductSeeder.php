<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Pensil', 'price' => 1000, 'stock' => 50],
            ['name' => 'Buku Tulis', 'price' => 5000, 'stock' => 30],
            ['name' => 'Penghapus', 'price' => 2000, 'stock' => 100],
            ['name' => 'Bolpoin', 'price' => 3000, 'stock' => 80],
            ['name' => 'Penggaris', 'price' => 2500, 'stock' => 40],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

// php artisan db:seed --class=ProductSeeder

