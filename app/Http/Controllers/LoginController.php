<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $userId = Auth::id();

            $data = User::find($userId);

            // menyimpan user id disession
            session([
                'userData' => $data,
            ]);

            // log activity
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'login',
            ]);

            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'login gagal!');

    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // log activity
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'logout',
        ]);

        return redirect('/');
    }
}


// harusnya penamaannya authController bukan loginController
