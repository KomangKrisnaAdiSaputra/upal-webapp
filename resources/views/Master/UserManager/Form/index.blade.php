@extends('layouts.main')
@section('title', $user?->id ?? null ? 'Edit Data' : 'Tambah Data')

@section('data')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Data</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ route('master.usermanager.savedata.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <input type="hidden" name="id" value="{{ $user?->id ?? '' }}">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="nama">Nama
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="nama" value="{{ $user?->nama ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="username">Username
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="username" value="{{ $user?->username ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="password">Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="password" {{ $user?->id ?? null ? '' : 'required' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="role">Role
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Please select</option>
                                            <option value="1" {{ $user?->role ?? null == 1 ? 'selected' : '' }}>
                                                Manajemen
                                            </option>
                                            <option value="2" {{ $user?->role ?? null == 2 ? 'selected' : '' }}>
                                                Operator
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="email">Email
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="email" value="{{ $user?->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="kontak">Kontak
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="kontak" name="kontak"
                                            placeholder="kontak" value="{{ $user?->kontak ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="jabatan">Jabatan
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            placeholder="jabatan" value="{{ $user?->jabatan ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row flex">
                                    <div class="col-lg-8 ml-auto">
                                        <a href="{{ route('master.usermanager') }}" class="btn btn-danger">Kembali</a>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
