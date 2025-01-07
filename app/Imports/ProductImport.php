<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $product = new Product([
            'name' => $row['nama'],
            'price' => $row['harga'],
            'category' => $row['kategori'],
            'unit' => $row['satuan'],
            'stock' => $row['stok'],
            'image' => $row['gambar'],
            'weight' => $row['berat'],
            'length' => $row['panjang'],
            'width' => $row['lebar'],
            'height' => $row['tinggi'],
            'description' => $row['deskripsi'],
        ]);

    $product->save();
    $product->generateSlug();

        return $product;
    }
}
