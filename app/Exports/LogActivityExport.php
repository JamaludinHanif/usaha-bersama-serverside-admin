<?php

namespace App\Exports;

use App\Models\LogActivity;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogActivityExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LogActivity::with('user')->get();
    }

        /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nama Pengguna',
            'Role',
            'Aktivitas',
            'Waktu'
        ];
    }

        /**
     * Memetakan data sebelum diekspor.
     *
     * @param mixed $logActivity
     * @return array
     */
    public function map($logActivity): array
    {
        static $rowNumber = 1;

        return [
            $rowNumber++,
            $logActivity->user->name ?? 'Pengguna tidak ditemukan',
            $logActivity->user->username ?? 'Pengguna tidak ditemukan',
            $logActivity->user->role ?? 'Pengguna tidak ditemukan',
            $logActivity->action,
            $logActivity->created_at->format('d-m-Y') . ', Pukul: ' . $logActivity->created_at->format('H:i:s'),
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
        $sheet->getStyle('A1:F1')->applyFromArray([
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
        $sheet->getStyle('A1:F' . $rowCount)->applyFromArray([
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
