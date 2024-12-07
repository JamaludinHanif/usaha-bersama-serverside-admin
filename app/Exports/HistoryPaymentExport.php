<?php

namespace App\Exports;

use App\Models\PaymentCode;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HistoryPaymentExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PaymentCode::with('user')->get();
    }

        /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Username',
            'Kasir',
            'Status',
            'Total Pembayaran',
            'Tipe',
            'Waktu'
        ];
    }

        /**
     * Memetakan data sebelum diekspor.
     *
     * @param mixed $payments
     * @return array
     */
    public function map($payments): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $payments->code,
            $payments->user->username ?? 'Tidak Ada',
            $payments->cashier->username ?? 'Tidak Ada',
            $payments->status,
            $payments->amount ?? 'nOL',
            $payments->type,
            $payments->created_at->format('Y-m-d H:i:s'),
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

}
