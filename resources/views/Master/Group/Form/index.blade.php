@extends('layouts.main')
@section('title', $group?->id ?? null ? 'Edit Data' : 'Tambah Data')

@section('data')
    <div class="col-lg-12 flex justify-center items-center min-h-screen">
        <div class="card w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
            <div class="card-header">
                <h4 class="card-title">Form Data</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ route('master.group.savedata.post') }}" method="POST">
                        @csrf
                        <div class="col-xl-6">
                            <input type="hidden" name="id" value="{{ $group?->id ?? '' }}">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="jalur">Jalur
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="jalur" name="jalur"
                                        placeholder="jalur" value="{{ $group?->jalur ?? '' }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="type">Type
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" style="text-transform: uppercase;"
                                        id="type" name="type" placeholder="type" value="{{ $group?->type ?? '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="status">Status
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group mb-0 col-lg-6">
                                    <label class="radio-inline mr-3"><input type="radio" name="status" value="1"
                                            {{ $group?->status ?? true ? 'checked' : '' }}> Aktif</label>
                                    <label class="radio-inline mr-3"><input type="radio" name="status" value="0"
                                            {{ $group?->status ?? true ? '' : 'checked' }}> Tidak Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row flex">
                            <div class="col-lg-8 ml-auto">
                                <a href="{{ route('master.group') }}" class="btn btn-danger">Kembali</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
