<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendToUserMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Kirim email ke alamat yang diterima
        Mail::to($request->email)->send(new SendToUserMail());

        return response()->json(['message' => 'Email sent successfully'], 200);
    }
}
