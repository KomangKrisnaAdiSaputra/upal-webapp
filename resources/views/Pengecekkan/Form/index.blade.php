@extends('layouts.main')
@section('title', $utilitas?->id ?? null ? 'Edit Data' : 'Tambah Data')

@section('data')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Data</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ route('pengecekkan.savedata.post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <input type="hidden" name="id" value="{{ $utilitas?->id ?? '' }}">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="password">Customer
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select name="id_customer" class="form-control select2">
                                            <option value="">-- Pilih Customer --</option>
                                            @foreach ($customers as $val)
                                                <option value="{{ $val['value'] }}"
                                                    {{ $utilitas?->id_customer ?? '' == $val['value'] ? 'selected' : '' }}>
                                                    {{ $val['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="password">Jenis
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select name="jenis" class="form-control select2">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($jenis as $val)
                                                <option value="{{ $val['value'] }}"
                                                    {{ $utilitas?->jenis ?? '' == $val['value'] ? 'selected' : '' }}>
                                                    {{ $val['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="password">Satuan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select name="satuan" class="form-control select2">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($satuan as $val)
                                                <option value="{{ $val['value'] }}"
                                                    {{ $utilitas?->satuan ?? '' == $val['value'] ? 'selected' : '' }}>
                                                    {{ $val['label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="tanggal">Tanggal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            placeholder="tanggal" value="{{ $utilitas?->tanggal ?? '' }}" required>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="nilai">Nilai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="number" class="form-control" id="nilai" name="nilai"
                                            placeholder="nilai" value="{{ $utilitas?->nilai ?? '' }}" required>
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

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Data",
                allowClear: true
            });
        });
    </script>

@endsection
