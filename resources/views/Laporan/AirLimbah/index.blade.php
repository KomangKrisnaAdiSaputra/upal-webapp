@extends('layouts.main')
@section('title', 'Laporan Air Limbah')

@section('data')
    <div class="col-12">
        <div class="flex items-center space-x-4 mb-6">
            <form action="#" id="form-filter">
                <div class="flex col-md-6 items-center space-x-2">
                    <label class="form-label text-sm font-medium" for="date">Tanggal</label>
                    <input type="date" id="date" value="{{ Carbon\Carbon::today()->toDateString() }}"
                        class="form-input py-2 px-3 border rounded-md">
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

        // function tabel(date = null) {
        //     $.get("{{ route('pengecekkan.airirigasi.gettabel') }}", {
        //         date
        //     }, function(data, status) {
        //         $('#data-tabel').html(data);
        //     });
        // }

        // $("#form-filter").submit(function(e) {
        //     e.preventDefault();
        //     tabel($("#date").val());
        // });
    </script>
@endsection
