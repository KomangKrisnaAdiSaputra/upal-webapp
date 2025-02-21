<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    function index()
    {
        $groups = Group::get();
        return view("Master.Group.index", compact('groups'));
    }

    function create()
    {
        return view("Master.Group.Form.index");
    }

    function edit(Request $request, $id)
    {
        $group = Group::find($id);
        return view("Master.Group.Form.index", compact('group'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_group = [
                'jalur' => $request->jalur,
                'type' => strtoupper($request->type),
                'status' => (bool)$request->status
            ];

            if (isset($request->id) && $request->id) {
                $group = Group::find($request->id);
                $group->update($data_group);
            } else {
                Group::create($data_group);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $route = isset($request->id) && $request->id ? 'master.group.edit.index' : 'master.group.create.index';
            return redirect()->route($route);
        }
        return redirect()->route('master.group');
    }
}
