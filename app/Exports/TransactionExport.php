<?php

namespace App\Exports;

use App\Models\Transaction;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaction::with('user')->get();
    }

        /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Invoice',
            'Pembeli',
            'Penjual',
            'Status',
            'Total Pembelian',
            'Waktu'
        ];
    }

        /**
     * Memetakan data sebelum diekspor.
     *
     * @param mixed $transaction
     * @return array
     */
    public function map($transaction): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $transaction->code_invoice,
            $transaction->user->username ?? 'Tidak Ada',
            $transaction->seller->shop_name ?? 'Tidak Ada',
            $transaction->status,
            $transaction->priceFormatted(),
            $transaction->created_at->translatedFormat('Y-m-d H:i:s'),
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
        $sheet->getStyle('A1:G1')->applyFromArray([
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
        $sheet->getStyle('A1:G' . $rowCount)->applyFromArray([
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


