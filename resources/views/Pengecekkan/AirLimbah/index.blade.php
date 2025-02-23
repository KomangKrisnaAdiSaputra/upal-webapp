@extends('layouts.main')
@section('title', 'Jasa Pengelolaan Air Limbah')

@section('data')
    <div class="col-12">
        <form action="#" id="form-filter" class="p-3 bg-white shadow rounded">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-medium" for="date">Bulan</label>
                    <select name="date" id="date" class="form-select">
                        <option value="">-- Pilih Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            @php
                                $monthValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $selected = $monthValue == date('m') ? 'selected' : ''; // Menandai bulan saat ini
                            @endphp
                            <option value="{{ date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01' }}"
                                {{ $selected }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>
            </div>
        </form>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Data Air Limbah</h4>
                <a href="#" class="btn btn-rounded btn-primary"
                    onclick="Modal('{{ route('pengecekkan.airlimbah.form') }}', 'modal-lg', 'Tambah Data')">
                    Tambah Data
                </a>
            </div>

            <div class="card-body">

                <div class="table-responsive" id="data-tabel" style="overflow-x: hidden !important;" />

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            tabel();
        });

        function tabel(date = null) {
            $('#data-tabel').html(spinner());

            $.get("{{ route('pengecekkan.airlimbah.gettabel') }}", {
                date
            }, function(data, status) {
                setTimeout(() => {
                    $('#data-tabel').html(data);
                }, 1000);
            });
        }

        $("#form-filter").submit(function(e) {
            e.preventDefault();
            tabel($("#date").val());
        });
    </script>
@endsection
