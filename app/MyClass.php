<?php
namespace App;

use Illuminate\Support\Facades\Http;

class MyClass
{
    public function sendMessageWhatsapp($number, $message, $fileUrl = null, $caption = null)
    {
        $urlApiWhatsapp = "https://d0e5-182-0-251-121.ngrok-free.app/send";

        $body = [
            "number" => $number,
        ];

        if ($fileUrl) {
            $body['fileUrl'] = $fileUrl;
            $body['caption'] = $caption;
        } else {
            $body['message'] = $message;
        }

        try {
            $responseApiWa = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($urlApiWhatsapp, $body);

            if ($responseApiWa->successful()) {
                return $responseApiWa->json();
            } else {
                return ['errorr' => $responseApiWa->json(), 'status' => $responseApiWa->status()];
            }
        } catch (\Exception $e) {
            return ['error' => 'Exception occurred: ' . $e->getMessage()];
        }
    }

    public function myAdminId()
    {
        return session('userData')->id;
    }

}
