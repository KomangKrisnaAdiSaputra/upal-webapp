<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    function index()
    {
        $customers = Customer::get();
        return view("Master.Customer.index", compact('customers'));
    }

    function create()
    {
        return view("Master.Customer.Form.index");
    }

    function edit(Request $request, $id)
    {
        $customer = Customer::find($id);
        return view("Master.Customer.Form.index", compact('customer'));
    }

    function saveData(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_customer = [
                'nama' => $request->nama,
                'catatan' => $request->catatan,
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
            dd($th->getMessage());
            $route = isset($request->id) && $request->id ? 'master.customer.edit.index' : 'master.customer.create.index';
            return redirect()->route($route);
        }
        return redirect()->route('master.customer');
    }
}
