@extends('layouts.main')
@section('title', 'Customer')

@section('css')
    <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

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
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->nama }}</td>
                                    <td>{{ $customer->catatan }}</td>
                                    <td>
                                        @if ($customer->status)
                                            <span class="badge badge-pill badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
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

@section('js')
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}" type="text/javascript"></script>
@endsection
