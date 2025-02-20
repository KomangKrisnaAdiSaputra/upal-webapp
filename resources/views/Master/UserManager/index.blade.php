@extends('layouts.main')
@section('title', 'User Manager')

@section('data')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data User</h4>
                <a href="{{ route('master.usermanager.create.index') }}" class="btn btn-rounded btn-primary">Tambah Data</a>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Kontak</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->jabatan }}</td>
                                    <td>{{ $user->kontak }}</td>
                                    <td>{{ $user->role_str }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('master.usermanager.edit.index', $user->id) }}"
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
