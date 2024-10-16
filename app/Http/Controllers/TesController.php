<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TesController extends Controller
{
    public function tesWa()
    {
        // $response = Http::get('https://wa.sinkron.com/send-message?api_key=iH21K14bt2p78TkhHbnjr2ffPVfGaB&sender=6285161310017&number=6283823538374&message=haloo');

        // $body = [
        //     "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
        //     "sender" => "6285161310017",
        //     // "number" => "6282120781678",
        //     "number" => "6282120781678",
        //     "message" => "halo mas",
        // ];

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post('https://wa.sinkron.com/send-message', $body);


        $body = [
            "api_key" => "iH21K14bt2p78TkhHbnjr2ffPVfGaB",
            "sender" => "6285161310017",
            "number" => "6282120781678",
            "media_type" => "image",
            "caption" => "Berikut adalah Invoice pembelian anda",
            // "url" => storage_path('app/public' . $filePath),
            // "url" => "https://heyzine.com/flip-book/df0c6086ba.html"
            "url" => "https://i.ibb.co.com/tc3L9WM/042981900-1474457725-youtube.jpg"
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(60)->post('https://wa.sinkron.com/send-media', $body);

        $data = $response->json();

        return $data;
    }
}
