<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckMissingImages extends Command
{
    protected $signature = 'images:check-missing';
    protected $description = 'Check if images are missing and update database accordingly';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::whereNotNull('image')->get(); // Ambil semua user yang memiliki gambar

        foreach ($users as $user) {
            $imagePath = storage_path('app/public/uploads/' . $user->image); // Sesuaikan dengan path storage Anda

            if (!file_exists($imagePath)) {
                // Jika file tidak ditemukan, ubah field image menjadi null
                $user->update(['image' => null]);
                $this->info("Updated user ID {$user->id}: Image not found, set to null.");
            }
        }

        $this->info('Image check completed.');
    }
}
