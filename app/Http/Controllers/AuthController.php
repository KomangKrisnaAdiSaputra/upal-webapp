<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    function indexRegister()
    {
        return view("Auth.register");
    }

    // POST
    function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ($user && Auth::attempt($request->only('username', 'password'))) {
            session()->flash('success', 'Login Sukses!');
            return redirect()->route('dashboard.index');
        }

        session()->flash('error', 'Email Atau Password Salah!');
        return redirect()->route('auth.login.index');
    }

    public function register(Request $request)
    {
        if (User::where('username', $request->username)->first()) {
            session()->flash('error', 'Username Sudah Digunakan!');
            return redirect()->route('auth.register.index');
        }

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'kontak' => $request->kontak,
            'password' => Hash::make($request->password),
            'role' => 2,
        ]);
        return redirect()->route('auth.login.index');
    }
    // END POST
}
