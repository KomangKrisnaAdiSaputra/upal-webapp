@extends('layouts.main')
@section('title', 'Laporan Air Irigasi')

@section('data')
    <div class="col-12">
        <form action="#" id="form-filter" class="p-4 bg-white shadow rounded">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-medium" for="tanggal_awal">Tanggal Awal</label>
                    <input type="date" id="tanggal_awal" value="{{ Carbon\Carbon::today()->toDateString() }}"
                        class="form-control py-2 px-3 border rounded-md">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium" for="tanggal_akhir">Tanggal Akhir</label>
                    <input type="date" id="tanggal_akhir" value="{{ Carbon\Carbon::today()->toDateString() }}"
                        class="form-control py-2 px-3 border rounded-md">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>
            </div>

            <!-- General Error Message -->
            <span id="error_message" class="text-danger small d-block mt-2"></span>
        </form>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Data Air Irigasi</h4>
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

        function tabel(body = {}) {
            $('#data-tabel').html(spinner());

            $.get("{{ route('laporan.airirigasi.gettabel') }}", {
                ...body
            }, function(data, status) {
                setTimeout(() => {
                    $('#data-tabel').html(data);
                }, 1000);
            });
        }

        $("#form-filter").submit(function(e) {
            e.preventDefault();
            const body = {
                tanggal_awal: $("#tanggal_awal").val(),
                tanggal_akhir: $("#tanggal_akhir").val(),
            };

            let errorMessage = $("#error_message");
            let tglAwal = new Date(body.tanggal_awal);
            let tglAkhir = new Date(body.tanggal_akhir);

            errorMessage.html("");

            if (tglAwal.getFullYear() !== tglAkhir.getFullYear() || tglAwal.getMonth() !== tglAkhir.getMonth()) {
                return errorMessage.html("Tanggal awal dan akhir harus dalam bulan dan tahun yang sama.");
            }

            tabel(body);
        });
    </script>
@endsection
