<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    function index()
    {
        $customers = Customer::orderBy("id")->get();
        return view("Master.Customer.index", compact('customers'));
    }

    function create()
    {
        $groups = Group::selectRaw("id as value, type as label")->where('status', 1)->get();
        return view("Master.Customer.Form.index", compact('groups'));
    }

    function edit(Request $request, $id)
    {
        $customer = Customer::find($id);
        $groups = Group::selectRaw("id as value, type as label")->where('status', 1)->get();

        return view("Master.Customer.Form.index", compact('customer', 'groups'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_customer = [
                'group_id' => $request->group_id,
                'nama' => $request->nama,
                'air_irigasi' => isset($request->air_irigasi) ? 1 : 0,
                'harga_air_irigasi' => $request->harga_air_irigasi,
                'air_limbah' => isset($request->air_limbah) ? 1 : 0,
                'harga_air_limbah' => $request->harga_air_limbah,
                'penanganan_air_limbah' => $request->penanganan_air_limbah,
                'status' => (bool)$request->status
            ];

            if (isset($request->id) && $request->id) {
                $customer = Customer::find($request->id);
                $customer->update($data_customer);
            } else {
                Customer::create($data_customer);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $route = isset($request->id) && $request->id ? 'master.customer.edit.index' : 'master.customer.create.index';
            return redirect()->route($route);
        }
        return redirect()->route('master.customer');
    }
}
