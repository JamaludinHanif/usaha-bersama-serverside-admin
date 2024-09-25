<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice Transaksi')
                    ->view('emails.sendEmailTes') // Nama view yang akan digunakan untuk email
                    ->attach($this->filePath, [
                        'as' => 'invoice.pdf', // Nama file lampiran
                        'mime' => 'application/pdf', // MIME type file lampiran
                    ]);
    }
}
