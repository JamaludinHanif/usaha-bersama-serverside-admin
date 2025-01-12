<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use App\Models\User;
use App\MyClass\Fonnte;
use App\MyClass\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthBuyerController extends Controller
{
    // view
    public function viewRegister()
    {
        return view('buyer.auth.register');
    }

    public function viewLogin()
    {
        return view('buyer.auth.login');
    }

    public function viewOtp($username)
    {
        return view('buyer.auth.verifyOtp', [
            'title' => 'Verifikasi OTP',
            'user' => User::where('username', $username)->first(),
        ]);
    }

    // system
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'min:3', 'max:100', 'unique:users'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|unique:users',
        ], [
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
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        DB::beginTransaction();

        try {
            $otp = rand(1000, 9999);
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => 'buyer',
                'email' => $request->email,
                'no_hp' => Helper::idPhoneNumberFormat($request['no_hp']),
                'otp' => $otp,
                'password' => bcrypt($request->password),
            ];

            $to = $request->no_hp;
            $message = "📌 *Kode Verifikasi Usaha Bersama* \n\n" .
                "Halo *{$request->name}*, terima kasih telah mendaftar di *Usaha Bersama*. Berikut adalah kode verifikasi Anda:\n\n" .
                "🔑 *{$otp}*\n\n" .
                "Jangan berikan kode ini kepada siapa pun!!, termasuk pihak yang mengaku dari *Usaha Bersama*.\n\n" .
                "Jika Anda tidak merasa melakukan pendaftaran, abaikan pesan ini.\n\n" .
                "Salam hangat,\n" .
                "*Tim Usaha Bersama*";

            $response = Fonnte::sendMessage($to, $message);

            User::create($data);
            DB::commit();

            return response()->json(['message' => 'Pendaftaran berhasil! Silahkan lanjut verifikasi OTP.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Pendaftaran gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
        ], [
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.digits' => 'Kode OTP hanya terdiri dari 4 Nomor',
        ]);

        DB::beginTransaction();
        try {
            $user = User::where('id', $request->id)->first();
            if ($user->otp !== $request->otp) {
                return response()->json(['message' => 'OTP salah, silahkan coba lagi'], 400);
            }
            $user->update([
                'otp' => null,
                'is_verify' => 'yes',
            ]);

            // log activity
            LogActivity::create([
                'user_id' => $user->id,
                'action' => 'verifikasi OTP',
            ]);

            Auth::login($user);

            session([
                'userData' => $user,
            ]);

            DB::commit();

            return response()->json(['success' => 'Verifikasi OTP Berhasil!!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Verifikasi gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|string|min:5',
        ], [
            'username.required' => 'Username tidak boleh kosong.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 5 karakter.',
        ]);

        DB::beginTransaction();

        try {
            if (Auth::attempt($request->all())) {
                $userId = Auth::id();
                $data = User::find($userId);

                if ($data->is_verify == 'no') {
                    return response()->json(['message' => 'Akun belum diverifikasi!', 'data' => $data], 401);
                }

                // log activity
                LogActivity::create([
                    'user_id' => $userId,
                    'action' => 'melakukan login',
                ]);

                session([
                    'userData' => $data,
                ]);

                DB::commit();

                return response()->json(['success' => 'Login berhasil!', 'data' => $data], 200);
            } else {
                return response()->json(['message' => 'Username atau Password salah!'], 401);
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Login gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/')->with('logout-success', 'Logout Berhasil');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ], [
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return response()->json(['success' => 'Password berhasil diubah!', 'user' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Ganti Password gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }

    }

    // forgot password
    // Menampilkan form lupa password
    public function viewForgotPassword()
    {
        return view('buyer.auth.forgotPassword');
    }

    // Mengirimkan link reset password
    public function showForgotForm()
    {
        return view('auth.custom-forgot-password');
    }

    // Mengirim link reset password
    public function sendResetLink(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|exists:users,email',
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.exists' => 'Email ini belum terdaftar.',
        ]);

        DB::beginTransaction();

        try {
            $token = Str::random(64);

            // Simpan token di tabel reset password
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => Carbon::now()]
            );

            $resetLink = route('buyer.forgotPassword.reset', ['token' => $token]);
            Mail::send('emails.resetPassword', ['resetLink' => $resetLink], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Permintaan Reset Password');
            });

            DB::commit();

            return response()->json(['success' => 'Link reset password telah dikirim ke email Anda!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Lik reset password gagal dikirim. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }

    // Menampilkan form reset password
    public function showResetForm($token)
    {
        return view('buyer.auth.resetPassword', ['token' => $token]);
    }

    // Memproses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8',
        ], [
            'token' => 'Token tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong.',
            'email.exists' => 'Email ini belum terdaftar.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
        ]);

        DB::beginTransaction();

        try {
            // Cek token dan email
            $reset = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();

            if (!$reset) {
                return response()->json(['info' => 'Token tidak valid atau sudah kadaluarsa.'], 200);
            }

            // Update password
            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password),
            ]);

            // Hapus token
            DB::table('password_resets')->where('email', $request->email)->delete();

            DB::commit();

            return response()->json(['success' => 'Reset password berhasil!, silahkan login ulang'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Reset password gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }
}
