@extends('layouts.main')
@section('title', 'Customer')

@section('data')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Customer</h4>
                <a href="{{ route('master.customer.create.index') }}" class="btn btn-rounded btn-primary">Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga Air Irigasi (Rp)</th>
                                <th>Harga Air Limbah (Rp)</th>
                                <th>Sistem Penagihan Air Limbah</th>
                                <th>Group</th>
                                <th>Pelanggan Air Irigasi</th>
                                <th>Pelanggan Air Limbah</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->nama }}</td>
                                    <td class="text-right">{{ $customer?->harga_air_irigasi ?? 0 }}</td>
                                    <td class="text-right">{{ $customer?->harga_air_limbah ?? 0 }}</td>
                                    <td>{{ $customer->penanganan_air_limbah }}</td>
                                    <td>{{ ucwords(strtolower($customer->group->type)) }}</td>
                                    <td class="text-center">
                                        @if ($customer->air_irigasi)
                                            <span class="badge badge-pill badge-primary">Berlangganan</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Tidak Berlangganan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($customer->air_limbah)
                                            <span class="badge badge-pill badge-primary">Berlangganan</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Tidak Berlangganan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($customer->status)
                                            <span class="badge badge-pill badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('master.customer.edit.index', $customer->id) }}"
                                                class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                    class="fa fa-pencil"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
