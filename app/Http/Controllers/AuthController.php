<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function indexLogin()
    {
        return view("Auth.login");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login.index');
    }

    // POST
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            if (auth()->user()->status == 0) {
                session()->flash('error', 'Akun Anda Sudah Tidak Aktif!');
                return redirect()->route('auth.login.index');
            } elseif (auth()->user()->status == 1 && auth()->user()->role == 1 && auth()->user()->role == 2) {
                session()->flash('success', 'Login Sukses!');
                return redirect()->route('dashboard.index');
            } elseif (auth()->user()->status == 2) {
                session()->flash('error', 'Akun Anda Belum Di Verifikasi!');
                return redirect()->route('auth.login.index');
            }
        }

        session()->flash('error', 'Email Atau Password Salah!');
        return redirect()->route('auth.login.index');
    }
    // END POST
}
