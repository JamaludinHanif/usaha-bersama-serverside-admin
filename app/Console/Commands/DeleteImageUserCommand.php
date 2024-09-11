<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteImageUserCommand extends Command
{
    // Nama perintah command yang akan digunakan di terminal
    protected $signature = 'image:delete';  // Ganti sesuai dengan keperluan

    // Deskripsi singkat tentang command
    protected $description = 'Menghapus semua file di folder uploads dalam storage';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Hapus semua file di folder 'uploads'
        Storage::disk('public')->deleteDirectory('uploads');

        // Tampilkan pesan sukses
        $this->info('Semua file berhasil dihapus dari folder uploads.');
    }
}
