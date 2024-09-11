<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function showUserData()
    {
        $userId = session('user_id');
        return view('components.nav-bar', [
            'datas' => User::find($userId)
        ]);
    }
}
