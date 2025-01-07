<?php

namespace App\MyClass;

use Illuminate\Support\Facades\Http;

class Fonnte
{
    protected static $apiUrl = 'https://api.fonnte.com/send';

    public static function sendMessage($to, $message, $imageUrl = null)
    {
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->post(self::$apiUrl, [ // Menggunakan self:: untuk properti statis
            'target'   => $to, // Nomor tujuan, contoh: "628123456789"
            'message'  => $message, // Pesan teks
            // 'url'      => $imageUrl, // Opsional, URL gambar
            // 'delay'    => 2, // Opsional, delay dalam detik
        ]);

        return $response->json();
    }
}
