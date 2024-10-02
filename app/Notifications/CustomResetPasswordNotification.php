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
        $url = config('app.frontend_url') . '/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email);

        return (new MailMessage)
                    ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
                    ->action('Reset Password', $url)
                    ->line('Silahkan klik link diatas untuk lanjut ke langkah berikutnya');
    }
}
