@extends('layouts.main')
@section('title', 'Jasa Pengelolaan Air Limbah')

@section('data')
    <div class="col-12">
        <div class="flex items-center space-x-4 mb-6">
            <form action="#" id="form-filter">
                <div class="flex col-md-6 items-center space-x-2">
                    <label class="form-label text-sm font-medium" for="date">Bulan</label>
                    <select name="date" id="date" class="form-control">
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

                <div class="flex space-x-4">
                    <button type="submit"
                        class="btn btn-primary py-2 px-6 bg-blue-500 text-white rounded-md hover:bg-blue-600">Tampilkan</button>
                </div>
            </form>
        </div>
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
            $.get("{{ route('pengecekkan.airlimbah.gettabel') }}", {
                date
            }, function(data, status) {
                $('#data-tabel').html(data);
            });
        }

        $("#form-filter").submit(function(e) {
            e.preventDefault();
            tabel($("#date").val());
        });
    </script>
@endsection
