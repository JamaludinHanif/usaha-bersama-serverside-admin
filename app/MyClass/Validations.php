<?php

namespace App\MyClass;

use Illuminate\Validation\Rule;

class Validations
{

    public static function validationUser($request, $userID = null)
    {
        $validation = [
            'name' => 'required',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email:dns|unique:users',
        ];

        if (!empty($userID)) {
            $validation['username'] = [
                Rule::unique('users')->ignore($userID),
            ];
            $validation['email'] = [
                Rule::unique('users')->ignore($userID),
            ];
        }

        if (empty($userID)) {
            $validation['password'] = 'required|min:5';
        }

        $request->validate($validation, [
            'name.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email tidak tersedia. Mohon gunakan email lain',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password wajib berisi minimal 5 karakter',
        ]);
    }

    public static function validationProduct($request, $productID = null)
    {
        $validation = [
            'name' => 'required',
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email:dns|unique:users',
        ];

        if (!empty($userID)) {
            $validation['username'] = [
                Rule::unique('users')->ignore($userID),
            ];
            $validation['email'] = [
                Rule::unique('users')->ignore($userID),
            ];
        }

        if (empty($userID)) {
            $validation['password'] = 'required|min:5';
        }

        $request->validate($validation, [
            'name.required' => 'Nama wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email tidak tersedia. Mohon gunakan email lain',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password wajib berisi minimal 5 karakter',
        ]);
    }

    public static function validationPhoto($request)
    {

        $request->validate([
            'filename' => 'required|image|mimes:png,jpg,gif',
            'description' => 'nullable',

        ],
            [
                'filename.required' => 'foto harus di isi',
                'filename.image' => 'file harus berupa foto',
                'filename.mimes' => 'format wajib berupa png,jpg,gif',
            ]);
    }
}
