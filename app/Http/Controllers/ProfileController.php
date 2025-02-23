<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function index()
    {
        return view("Profile.index");
    }

    function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_update = [
                'username' => $request->username,
                'nama' => $request->nama,
                'email' => $request->email,
                'kontak' => $request->kontak
            ];

            if ($request->password) $data_update['password'] = Hash::make($request->password);

            User::find(auth()->user()->id)->update($data_update);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('profile.index');
    }
}
