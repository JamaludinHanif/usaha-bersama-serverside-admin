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
        return new Product([
            'name' => $row['nama'],
            'price' => $row['harga'],
            'category' => $row['kategori'],
            'unit' => $row['satuan'],
            'stock' => $row['stok'],
            'image' => $row['gambar'],
        ]);
    }
}
