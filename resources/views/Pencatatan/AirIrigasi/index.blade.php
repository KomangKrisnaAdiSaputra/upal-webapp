@extends('layouts.main')
@section('title', 'Check List Harian Pemakaian Air Irigasi')

@section('data')
    <div class="col-12">
        <form action="#" id="form-filter" class="p-4 bg-white shadow rounded">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-medium" for="date">Tanggal</label>
                    <input type="date" id="date" value="{{ Carbon\Carbon::today()->toDateString() }}"
                        class="form-control py-2 px-3 border rounded-md">
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
                <h4 class="card-title">Data Air Irigasi</h4>
                <div class="flex">
                    <a href="#" class="btn btn-rounded btn-success" onclick="exportExcel()">
                        Export Excel
                    </a>
                    {{-- <a href="#" class="btn btn-rounded btn-danger" onclick="exportPdf()">
                        Export PDF
                    </a> --}}
                    <a href="#" class="btn btn-rounded btn-primary" onclick="handleCreate()">
                        Tambah Data
                    </a>
                </div>
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

            $.get("{{ route('pencatatan.airirigasi.gettabel') }}", {
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

        // function exportPdf() {
        //     const date = $("#date").val();
        //     let link = "route('pencatatan.airirigasi.pdf', ['date' => '__DATE__'])";
        //     link = link.replace('__DATE__', date);
        //     window.open(link);
        // }

        function exportExcel() {
            const date = $("#date").val();
            let link = "{{ route('pencatatan.airirigasi.exportexcel', ['date' => '__DATE__']) }}";
            link = link.replace('__DATE__', date);
            window.open(link);
        }

        function handleCreate() {
            const date = $("#date").val();

            let link = "{{ route('pencatatan.airirigasi.form', ['date' => '__DATE__']) }}";
            link = link.replace('__DATE__', date);
            Modal(link, 'modal-lg', 'Tambah Data')
        }
    </script>
@endsection
