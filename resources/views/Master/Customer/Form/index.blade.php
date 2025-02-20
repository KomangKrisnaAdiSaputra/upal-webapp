@extends('layouts.main')
@section('title', $user?->id ?? null ? 'Edit Data' : 'Tambah Data')

@section('data')
    <div class="col-lg-12 flex justify-center items-center min-h-screen">
        <div class="card w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
            <div class="card-header">
                <h4 class="card-title">Form Data</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ route('master.customer.savedata.post') }}" method="POST">
                        @csrf
                        <div class="col-xl-6">
                            <input type="hidden" name="id" value="{{ $customer?->id ?? '' }}">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="nama">Nama
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="nama" value="{{ $customer?->nama ?? '' }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="username">Catatan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <textarea class="form-control" id="catatan" name="catatan" rows="5" placeholder="catatan">{{ $customer?->catatan ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Status
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group mb-0 col-lg-6">
                                    <label class="radio-inline mr-3"><input type="radio" name="status" value="1"
                                            {{ $customer?->status ?? true ? 'checked' : '' }}> Aktif</label>
                                    <label class="radio-inline mr-3"><input type="radio" name="status" value="0"
                                            {{ $customer?->status ?? true ? '' : 'checked' }}> Tidak Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row flex">
                            <div class="col-lg-8 ml-auto">
                                <a href="{{ route('master.customer') }}" class="btn btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
