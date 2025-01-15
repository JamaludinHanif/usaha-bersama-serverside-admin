<?php

namespace App\Exports;

use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

        /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Harga',
            'Satuan',
            'Stok',
            'Kategori',
            'Berat (gram)',
            'Panjang (cm)',
            'Lebar (cm)',
            'Tinggi (cm)',
            'Gambar'
        ];
    }

    /**
     * Memetakan data sebelum diekspor.
     *
     * @param mixed $product
     * @return array
     */
    public function map($product): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $product->name,
            $product->priceFormatted() ?? 'Tidak Ada',
            $product->unit,
            $product->stock,
            $product->category,
            $product->weight,
            $product->length,
            $product->width,
            $product->height,
            $product->image,
        ];
    }

    /**
     * Mengatur style untuk heading dan sel lainnya.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF538DD5'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Mengambil jumlah baris data untuk menambahkan border
        $rowCount = $this->collection()->count() + 1;

        // Mengatur border untuk semua sel yang berisi data
        $sheet->getStyle('A1:K' . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Warna hitam
                ],
            ],
        ]);

        return [];
    }

}
