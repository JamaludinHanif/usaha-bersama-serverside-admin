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
                'action' => 'melakukan login',
            ]);

            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'login gagal!');

    }

    public function authenticateApi(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $userId = Auth::id();

            $data = User::find($userId);

            // log activity
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'melakukan login',
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal',
                'errors' => 'Periksa kembali username dan passwordnya',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Server error',
            'errors' => 'server error',
        ], 500);
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
            'action' => 'melakukan logout',
        ]);

        return redirect('/');
    }

    public function logoutApi(Request $request)
    {
        try {

        $userId = $request->userId;
        Auth::logout();

        // log activity
        LogActivity::create([
            'user_id' => $userId,
            'action' => 'melakukan logout',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ], 200);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan pesan error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat logout',
                'errors' => $e->getMessage(), // Mengembalikan pesan kesalahan yang lebih spesifik
            ], 500);
        }
    }
}


// harusnya penamaannya authController bukan loginController
