<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDFUser(Request $request)
    {
        // dd($request->input('role'));

        // Membuat instance mPDF
        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);

        $role = $request->input('role');

        // Query data user berdasarkan filter jika diperlukan
        $users = User::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'title' => 'Laporan Data Pengguna',
            'date' => date('d/F/Y'),
            'users' => $users
        ];

        // // Konten yang akan dimasukkan ke PDF
        // $html = '<h1>Ini adalah contoh PDF menggunakan mPDF di Laravel 9</h1>';

        // // Menulis konten ke PDF
        // $mpdf->WriteHTML($html);

        $users = User::all();

        $html = view('pdf.userData', $data)->render();
        $mpdf->WriteHTML($html);

        // Mengirimkan file PDF ke browser untuk didownload
        return $mpdf->Output('data-user.pdf', 'I'); // 'D' untuk force download, 'I' untuk inline di browser
    }

    public function generatePDFLog(Request $request)
    {
        // dd($request->input('date'));

        // Membuat instance mPDF
        $mpdf = new Mpdf();

        $date = $request->input('date');

        // Query data user berdasarkan filter jika diperlukan
        // $logs = LogActivity::when($date, function ($query, $date) {
        //     // $query->whereDate('created_at', $date);
        //     // $query->user->username;
        //     return $query->whereDate('created_at', $date);
        // })->get();
        $logs = LogActivity::with('user')->when($date, function ($query, $date) {
            return $query->whereDate('created_at', $date);
        })->get();


        // dd($logs->toArray());

        // Data yang akan dikirim ke view PDF
        if ($date != null) {
            $data = [
                'title' => 'Laporan Data Pengguna',
                'type' => 'byDate',
                'logs' => $logs
            ];
        } else {
            $data = [
                'title' => 'Laporan Data Pengguna',
                'type' => 'all',
                'logs' => $logs
            ];
        }

        // // Konten yang akan dimasukkan ke PDF
        // $html = '<h1>Ini adalah contoh PDF menggunakan mPDF di Laravel 9</h1>';

        // // Menulis konten ke PDF
        // $mpdf->WriteHTML($html);

        $logs = LogActivity::all();

        $html = view('pdf.logActivityPdf', $data)->render();
        $mpdf->WriteHTML($html);

        // Mengirimkan file PDF ke browser untuk didownload
        return $mpdf->Output('data-log.pdf', 'D'); // 'D' untuk force download, 'I' untuk inline di browser
    }
}
