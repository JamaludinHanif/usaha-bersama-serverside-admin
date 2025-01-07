<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\User;
use App\MyClass\Fonnte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'action' => 'logout',
        ]);

        return redirect('/');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => ['required', 'captcha'],
        ]);

        // Ambil kredensial tanpa g-recaptcha-response
        $credentials = $request->only('username', 'password');

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

        return back()->with('loginError', 'login gagal!, silahkan periksa kembali username dan passwordnya');

    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('')]);
    }

    // buyer


    public function loginBuyer(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $userId = Auth::id();
            $data = User::find($userId);

            if ($data->is_verify == 'no') {
                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal',
                    'errors' => 'Akun anda belum terverifikasi',
                ], 200);
            }

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
            'password' => 'required|min:5|max:100',
            'no_hp' => 'required|unique:users',
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
            'no_hp.required' => 'Nomor Hp wajib diisi',
            'no_hp.unique' => 'Nomor Hp sudah digunakan',
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
            DB::beginTransaction();
            try {
                $otp = rand(1000, 9999);
                $data = [
                    'name' => $request->name,
                    'username' => $request->username,
                    'role' => 'buyer',
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'otp' => $otp,
                    'password' => bcrypt($request->password),
                ];

                $to = $request->no_hp;
                $message = "📌 *Kode Verifikasi Usaha Bersama* \n\n" .
                    "Halo, terima kasih telah mendaftar di *Usaha Bersama*. Berikut adalah kode verifikasi Anda:\n\n" .
                    "🔑 *{$otp}*\n\n" .
                    "Jangan berikan kode ini kepada siapa pun!!, termasuk pihak yang mengaku dari *Usaha Bersama*.\n\n" .
                    "Jika Anda tidak merasa melakukan pendaftaran, abaikan pesan ini.\n\n" .
                    "Salam hangat,\n" .
                    "*Tim Usaha Bersama*";

                $response = Fonnte::sendMessage($to, $message);

                User::create($data);
                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil membuat akun, Silahkan cek Whatsapp kamu untuk mengisi OTP',
                    'response_fonnte' => $response,
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'status' => false,
                    'message' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}",
                    // 'response_fonnte' => $response
                ], 500);
            }
        }

    }

    public function verifyOtp(Request $request)
    {
        $data = $request->all();

        $rules = [
            'otp' => 'required|digits:4',
        ];

        $validasi = Validator::make($data, $rules, [
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.digits' => 'Kode OTP hanya terdiri dari 4 Nomor',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validasi->errors(),
            ], 200);
        } else {
            DB::beginTransaction();
            try {
                $user = User::where('no_hp', $request->no_hp)->first();
                if ($user->otp !== $request->otp) {
                    return response()->json(['message' => 'Invalid OTP'], 400);
                }
                $user->update([
                    'otp' => null,
                    'is_verify' => 'yes',
                ]);
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Pendaftaran akun berhasil',
                ], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json([
                    'status' => false,
                    'message' => "File : {$e->getFile()} | Line : {$e->getLine()} | Message : {$e->getMessage()}",
                ], 500);
            }
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
                // $frontendUrl = $token;
                // Kirim link reset password yang mengarah ke frontend
                $user->sendPasswordResetNotification($token);
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
