<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'login',
        ]);
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

        return back()->with('loginError', 'login gagal!, silahkan periksa kembali username dan passwordnya');

    }


    // apiiii
    public function authenticateApi(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $userId = Auth::id();

            // return response()->json([
            //     'status' => false,
            //     'message' => 'Login gagal',
            //     'errors' => 'Periksa kembali username dan passwordnya',
            //     'data' => Auth::attempt($credentials)
            // ], 200);

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

    public function register(Request $request)
    {

        $data = $request->all();

        $rules = [
            'name' => 'required|max:100',
            'username' => ['required', 'min:3', 'max:100', 'unique:users'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => 'required|min:5|max:100'
        ];

        $validasi = Validator::make($data, $rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 5 karakter',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validasi->errors(),
            ], 200);
        } else {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];

            User::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil membuat akun, Silahkan Login',
            ], 200);
        }

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

        } catch (Exception $e) {
            // Tangani kesalahan dan kembalikan pesan error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat logout',
                'errors' => $e->getMessage(), // Mengembalikan pesan kesalahan yang lebih spesifik
            ], 500);
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Dapatkan status pengiriman link reset
        $status = Password::sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                $frontendUrl = config('app.frontend_url') . '/reset-password/' . $token;
                // Kirim link reset password yang mengarah ke frontend
                $user->sendPasswordResetNotification($frontendUrl);
            }
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)], 200)
                    : response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? response()->json(['message' => __($status)], 200)
                    : response()->json(['message' => __($status)], 200);
    }
}
