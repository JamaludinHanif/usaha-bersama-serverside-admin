<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    // Method via untuk menentukan channel pengiriman
    public function via($notifiable)
    {
        return ['mail'];  // Kirim via email
    }

    public function toMail($notifiable)
    {
        // Ambil frontend URL
        $frontendUrl = rtrim(config('app.frontend_url'), '/');
        \Log::info('Frontend URL: ' . $frontendUrl); // Log nilai frontendUrl

        // Log nilai token dan email untuk verifikasi
        \Log::info('Token: ' . $this->token);
        \Log::info('Email: ' . $notifiable->email);

        // Gabungkan token dan email
        $url = $frontendUrl . '/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email);

        \Log::info('Reset Password URL: ' . $url); // Debugging log

        return (new MailMessage)
                    ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
                    ->action('Reset Password', $url)
                    ->line('Jika Anda tidak meminta reset password, tidak ada tindakan lebih lanjut yang diperlukan.');
    }

}
