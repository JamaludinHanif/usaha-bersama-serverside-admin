<?php

namespace App\Exports;

use App\Models\Seller;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class SellersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Seller::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nama Toko',
            'Status',
            'Email',
            'Nomor Hp',
            'Profit',
            'Alamat/Lokasi',
        ];
    }

    /**
     * Memetakan data sebelum diekspor.
     *
     * @param mixed $seller
     * @return array
     */
    public function map($seller): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $seller->name ?? 'Penjual Tidak Ditemukan',
            $seller->shop_name ?? 'Penjual Tidak Ditemukan',
            $seller->status ?? 'Penjual Tidak Ditemukan',
            $seller->email ?? 'Penjual Tidak Ditemukan',
            $seller->no_hp ?? 'Penjual Tidak Ditemukan',
            $seller->profit ?? 'Penjual Tidak Ditemukan',
            $seller->location ?? 'Penjual Tidak Ditemukan',
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
        $sheet->getStyle('A1:H1')->applyFromArray([
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
        $sheet->getStyle('A1:H' . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Warna hitam
                ],
            ],
        ]);

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
