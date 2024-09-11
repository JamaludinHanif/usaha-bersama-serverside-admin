<?php

namespace App\Exports;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateImport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * Mengembalikan data array untuk template Excel.
     *
     * @return array
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Mendefinisikan heading untuk template.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Username',
            'Role',
            'Name',
            'Email',
            'Password'
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
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF538DD5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Mengatur border untuk heading
        $sheet->getStyle('A1:E1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Mengambil daftar username dari database
        $usernames = User::pluck('username')->toArray();
        $usernameList = implode(',', $usernames); // Mengubah array menjadi string yang dipisahkan koma

        // Menambahkan dropdown list di kolom B (Role)
        $validation = $sheet->getCell('B2')->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST)
                   ->setFormula1('"' . $usernameList . '"') // Daftar opsi untuk dropdown
                   ->setAllowBlank(false)
                   ->setShowDropDown(true)
                   ->setErrorTitle('Invalid input')
                   ->setError('Please select a value from the list.');

        // Mengatur dropdown untuk seluruh kolom B
        $sheet->setDataValidation('B2:B100', $validation);

        return [];
    }
}
