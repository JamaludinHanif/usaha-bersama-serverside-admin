<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TesController extends Controller
{
        // generate nim
    // Menampilkan tampilan dengan tombol
    public function indexGenerate()
    {
        return view('tes');
    }

        // Menggenerate kode dan menyimpan nomor urut di session
        public function generateNim()
        {
            $year = date('y');

            // Ambil nomor urut terakhir dari session
            $NomorUrut = session('no_urut', 0);

            // Tambah nomor urut
            $newSequence = str_pad($NomorUrut + 1, 3, '0', STR_PAD_LEFT);

            // matkul
            $matkul = '090';

            // Simpan nomor urut baru ke session
            session(['no_urut' => $NomorUrut + 1]);

            // Gabungkan tahun dan nomor urut
            $code = $year . $matkul .  $newSequence;

            return redirect()->route('code.index')->with('code', $code);
        }
        // end generate nim

        public function ranking()
        {
            $data = [
                [
                    'type' => 1,
                    'name' => 'Jamaludin Hanif',
                    'role' => 'XII Rpl 5',
                    'point' => 463,
                    'ranking' => 1,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 96
                ],
                [
                    'type' => 1,
                    'name' => 'Betty Fisher',
                    'role' => 'XII Rpl 1',
                    'point' => 360,
                    'ranking' => 2,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 75
                ],
                [
                    'type' => 1,
                    'name' => 'Richard Hudson',
                    'role' => 'XII Rpl 1',
                    'point' => 345,
                    'ranking' => 3,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 72
                ],
                [
                    'type' => 1,
                    'name' => 'Melissa Miller',
                    'role' => 'XII Rpl 2',
                    'point' => 336,
                    'ranking' => 4,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 70
                ],
                [
                    'type' => 1,
                    'name' => 'Mark Hall',
                    'role' => 'XII Rpl 5',
                    'point' => 325,
                    'ranking' => 5,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 68
                ],
                [
                    'type' => 1,
                    'name' => 'Bradley Jones',
                    'role' => 'XII Rpl 4',
                    'point' => 228,
                    'ranking' => 6,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 48
                ],
                [
                    'type' => 1,
                    'name' => 'Heather Mejia',
                    'role' => 'XII Rpl 5',
                    'point' => 219,
                    'ranking' => 7,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 46
                ],
                [
                    'type' => 1,
                    'name' => 'Sherry Williams',
                    'role' => 'XII Rpl 3',
                    'point' => 207,
                    'ranking' => 8,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 43
                ],
                [
                    'type' => 1,
                    'name' => 'Andrea Moon',
                    'role' => 'XII Rpl 4',
                    'point' => 129,
                    'ranking' => 9,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 27
                ],
                [
                    'type' => 1,
                    'name' => 'Lindsay Davis',
                    'role' => 'XII Rpl 4',
                    'point' => 114,
                    'ranking' => 10,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 24
                ],
                [
                    'type' => 2,
                    'name' => 'Patricia Gill',
                    'role' => 'Guru',
                    'point' => 480,
                    'ranking' => 1,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 100
                ],
                [
                    'type' => 2,
                    'name' => 'Michelle Bailey',
                    'role' => 'Guru',
                    'point' => 384,
                    'ranking' => 2,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 80
                ],
                [
                    'type' => 2,
                    'name' => 'Ernest Silva',
                    'role' => 'Guru',
                    'point' => 374,
                    'ranking' => 3,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 78
                ],
                [
                    'type' => 2,
                    'name' => 'Steve Moore',
                    'role' => 'Guru',
                    'point' => 371,
                    'ranking' => 4,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 77
                ],
                [
                    'type' => 2,
                    'name' => 'Rebecca Arellano',
                    'role' => 'Guru',
                    'point' => 329,
                    'ranking' => 5,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 69
                ],
                [
                    'type' => 2,
                    'name' => 'Tammy Griffin',
                    'role' => 'Guru',
                    'point' => 221,
                    'ranking' => 6,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 46
                ],
                [
                    'type' => 2,
                    'name' => 'Breanna Brown',
                    'role' => 'Guru',
                    'point' => 185,
                    'ranking' => 7,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 39
                ],
                [
                    'type' => 2,
                    'name' => 'Sheri Campbell',
                    'role' => 'Guru',
                    'point' => 126,
                    'ranking' => 8,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 26
                ],
                [
                    'type' => 2,
                    'name' => 'William Davis',
                    'role' => 'Guru',
                    'point' => 112,
                    'ranking' => 9,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 23
                ],
                [
                    'type' => 2,
                    'name' => 'Jennifer Johnson',
                    'role' => 'Guru',
                    'point' => 110,
                    'ranking' => 10,
                    'image' => 'https://i.ibb.co.com/1YghfBk/hanif-gatau123.jpg',
                    'persentase' => 23
                ]
            ];

            // pendefinisian data per type
            $type1Data = array_filter($data, function($item) {
                return $item['type'] == 1;
            });

            $type2Data = array_filter($data, function($item) {
                return $item['type'] == 2;
            });

            // Hitung total points untuk masing-masing type
            $totalPointsType1 = array_reduce($type1Data, function($carry, $item) {
                return $carry + $item['point'];
            }, 0);

            $totalPointsType2 = array_reduce($type2Data, function($carry, $item) {
                return $carry + $item['point'];
            }, 0);

            // Hitung persentase untuk masing-masing type
            foreach ($type1Data as &$item) {
                $item['persentase'] = ($totalPointsType1 > 0) ? round(($item['point'] / $totalPointsType1) * 100, 2) : 0;
            }

            foreach ($type2Data as &$item) {
                $item['persentase'] = ($totalPointsType2 > 0) ? round(($item['point'] / $totalPointsType2) * 100, 2) : 0;
            }

            // mengGabungkan kembali data
            $data = array_merge($type1Data, $type2Data);

            return response()->json($data);
        }

        public function fetchData()
        {
            $response = Http::get('https://equran.id/api/v2/surat');

            if ($response->successful()) {
                $data = $response->json();
                dd($data);
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Tidak dapat mengambil data dari API'], 500);
            }
        }

        public function checkOutV1()
        {
            // return view('pdf.invoiceV1');
            $formattedDate = now()->format('ymd-H:i:s');
            $noInvoice = 'INV-' . $formattedDate . '-' . session('userData')->id;


            // Data yang akan dimasukkan ke dalam PDF
            $data = [
                'title' => 'Invoice Transaksi',
                'content' => 'Ini adalah detail invoice untuk transaksi Anda.'
            ];

            // Membuat instance mPDF
            $mpdf = new Mpdf();

            // Mengambil view Laravel sebagai konten PDF
            $html = view('pdf.invoiceV1', $data)->render();

            // Menulis HTML ke dalam PDF
            $mpdf->WriteHTML($html);

            // Membuat nama file unik
            $uniqueFileName = 'invoice_' . time() . '_' . uniqid() . '.pdf';

            // Menyimpan file PDF di storage Laravel (misalnya: storage/app/public/invoices)
            // $path = storage_path('app/public/invoices/' . $uniqueFileName);
            $mpdf->Output($uniqueFileName, 'I'); // 'F' untuk save file

            // Mengirim email dengan lampiran PDF (opsional)
            // Mail::to('user@example.com')->send(new SendInvoice($uniqueFileName));

            return 'PDF telah dibuat dan disimpan sebagai: ' . $uniqueFileName;
        }

}
