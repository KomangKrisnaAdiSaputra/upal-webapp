@extends('layouts.main')
@section('title', 'Jasa Pengelolaan Air Limbah')

@section('data')
    <div class="col-12">
        <div class="flex items-center space-x-4 mb-6">
            <form action="#" id="form_air_limbah">
                <div class="flex items-center space-x-2">
                    <label class="form-label text-sm font-medium" for="Tanggal">Tanggal</label>
                    <input type="date" name="date_filter" value="{{ Carbon\Carbon::today()->toDateString() }}"
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
                <a href="javascript:void()" class="btn btn-rounded btn-primary"
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

        // $("#form_air_limbah").submit(function(e) {
        //     e.preventDefault();
        //     const formData = new FormData(this);
        //     const body = [];
        //     let date = "";
        //     const buttonClicked = e.originalEvent.submitter; // To ensure compatibility across browsers
        //     const actionType = buttonClicked.getAttribute("data-cek");

        //     if (actionType === "getdata") {
        //         formData.forEach((value, key) => {
        //             if (key == "date_filter") date = value;
        //         });
        //         tabel(date);

        //     } else if (actionType === "savedata") {
        //         formData.forEach((value, key) => {
        //             body[key] = value;
        //         });

        //         $.post("{{ route('pencatatan.mc.airlimbah.savedata.post') }}", {
        //             ...body
        //         }, function(data, status) {});
        //     }
        // });
    </script>
@endsection
