<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Mengubah baris Excel menjadi model User.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'username' => $row['username'],
            'role' => $row['role'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']), // Enkripsi password
        ]);
    }

    /**
     * Validasi data untuk memastikan bahwa data yang diimpor valid.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'role' => 'required|string|in:user,admin',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }
}
