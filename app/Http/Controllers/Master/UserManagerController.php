<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagerController extends Controller
{
    function index()
    {
        $users = User::get();
        return view("Master.UserManager.index", compact('users'));
    }

    function create()
    {
        return view("Master.UserManager.Form.index");
    }

    function edit(Request $request, $id)
    {
        $user = User::find($id);
        return view("Master.UserManager.Form.index", compact('user'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_user = [
                'username' => $request->username,
                'email' => $request->email,
                'nama' => $request->nama,
                'role' => $request->role,
                'kontak' => $request->kontak,
                'jabatan' => $request->jabatan
            ];

            if (isset($request->password) && $request->password != "") $data_user['password'] = Hash::make($request->password);

            if (isset($request->id) && $request->id) {
                $user = User::find($request->id);
                $user->update($data_user);
            } else {
                User::create($data_user);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $route = isset($request->id) && $request->id ? 'master.usermanager.edit.index' : 'master.usermanager.create.index';
            return redirect()->route($route);
        }
        return redirect()->route('master.usermanager');
    }
}
