<?php

namespace App\Http\Controllers\seller;

use App\Models\User;
use App\Models\Seller;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthSellerController extends Controller
{
    public function viewLogin()
    {
        return view('seller.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'shop_name' => 'required',
            'password' => 'required|string|min:5',
        ], [
            'shop_name.required' => 'Nama toko tidak boleh kosong.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 5 karakter.',
        ]);

        DB::beginTransaction();

        try {
            $seller = Seller::where('shop_name', $request->shop_name)->first();

            if (!$seller || $request->password !== $seller->password) {
                return response()->json(['message' => 'Nama toko atau Password salah!'], 401);
            }

            session([
                'userData' => $seller,
            ]);

            DB::commit();

            return response()->json(['success' => 'Login berhasil!', 'data' => $seller], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Login gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect(route('seller.loginView'))->with('logout-success', 'Logout Berhasil');
    }

    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'password' => 'required|string|min:8',
    //     ], [
    //         'password.required' => 'Kata sandi tidak boleh kosong.',
    //         'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $user = Auth::user();
    //         $user->password = Hash::make($request->password);
    //         $user->save();

    //         DB::commit();
    //         return response()->json(['success' => 'Password berhasil diubah!', 'user' => $user], 200);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json(['error' => 'Ganti Password gagal. Silakan coba lagi.', 'details' => $e->getMessage()], 500);
    //     }

    // }
}
