@extends('layouts.main')
@section('title', $customer?->id ?? null ? 'Edit Data' : 'Tambah Data')

@section('css')
    <style>
        .select2-container--bootstrap-5 .select2-selection {
            min-height: calc(2.4em + .77rem + 3px) !important;
            border-radius: 0.65rem !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 2.5 !important;
        }
    </style>
@endsection

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
                                <label class="col-lg-4 col-form-label" for="group_id">Group
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <select name="group_id" id="group_id" class="form-control select2">
                                        <option value="">-- Pilih Group --</option>
                                        @foreach ($groups as $val)
                                            <option value="{{ $val['value'] }}"
                                                {{ $customer?->group_id ?? '' == $val['value'] ? 'selected' : '' }}>
                                                {{ $val['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="air_irigasi" name="air_irigasi"
                                        {{ $customer?->air_irigasi ?? false ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="air_irigasi">Air Irigasi</label>
                                </div>
                                <label class="col-lg-4 col-form-label" for="nama">Harga Air Irigasi
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="number"
                                        class="form-control {{ $customer?->air_irigasi ?? false ? '' : 'custom-disabled' }}"
                                        id="harga_air_irigasi" name="harga_air_irigasi" placeholder="harga air irigasi"
                                        value="{{ $customer?->harga_air_irigasi ?? '' }}"
                                        {{ $customer?->air_irigasi ?? false ? 'required' : '' }} step="any">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="air_limbah" name="air_limbah"
                                        {{ $customer?->air_limbah ?? false ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="air_limbah">Air Limbah</label>
                                </div>
                                <label class="col-lg-4 col-form-label" for="nama">Harga Air Limbah
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="number"
                                        class="form-control {{ $customer?->air_limbah ?? false ? '' : 'custom-disabled' }}"
                                        id="harga_air_limbah" name="harga_air_limbah" placeholder="harga air irigasi"
                                        value="{{ $customer?->harga_air_limbah ?? '' }}"
                                        {{ $customer?->air_limbah ?? false ? 'required' : '' }} step="any">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="type_perhitungan">Type Perhitungan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <select name="type_perhitungan" id="type_perhitungan" class="form-control select2">
                                        <option value="">-- Pilih Data --</option>
                                        @foreach ($typePerhitungan as $val)
                                            <option value="{{ $val->value }}"
                                                {{ $customer?->type_perhitungan ?? '' == $val->value ? 'selected' : '' }}>
                                                {{ $val->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="nama">Perhitungan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" id="perhitungan" name="perhitungan"
                                        placeholder="perhitungan" value="{{ $customer?->perhitungan ?? '' }}"
                                        step="any" required>
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
                        <div class="col-lg-8">
                            <a href="{{ route('master.customer') }}" class="btn btn-danger">Kembali</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                allowClear: true,
                theme: "bootstrap-5"
            });
        });

        $("#air_irigasi").on("click", function() {
            const isChecked = $(this).prop("checked");
            const airIrigasi = $("#harga_air_irigasi");
            if (isChecked) {
                airIrigasi.removeClass("custom-disabled");
            } else {
                airIrigasi.val("");
                airIrigasi.addClass("custom-disabled");
            }
        });

        $("#air_limbah").on("click", function() {
            const isChecked = $(this).prop("checked");
            const airIrigasi = $("#harga_air_limbah");
            if (isChecked) {
                airIrigasi.removeClass("custom-disabled");
            } else {
                airIrigasi.val("");
                airIrigasi.addClass("custom-disabled");
            }
        });
    </script>

@endsection
