@extends('layouts.main')
@section('title', 'Pencatatan Minute Counter Air Irigasi')

@section('css')
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('data')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Air Irigasi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="#" id="form_air_limbah">
                        <div class="flex items-center space-x-4 mb-6">
                            <!-- Tanggal Input Section -->
                            <div class="flex items-center space-x-2">
                                <label class="form-label text-sm font-medium" for="Tanggal">Tanggal</label>
                                <input type="date" name="date_filter"
                                    value="{{ Carbon\Carbon::today()->toDateString() }}"
                                    class="form-input py-2 px-3 border rounded-md">
                            </div>

                            <!-- Button Group -->
                            <div class="flex space-x-4">
                                <button type="submit" data-cek="getdata"
                                    class="btn btn-primary py-2 px-6 bg-blue-500 text-white rounded-md hover:bg-blue-600">Tampilkan</button>
                                <button type="submit" data-cek="savedata"
                                    class="btn btn-secondary py-2 px-6 bg-green-500 text-white rounded-md hover:bg-green-600">Simpan</button>
                            </div>
                        </div>

                        <div id="data-tabel" />
                    </form>
                </div>

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
            $.get("{{ route('pencatatan.mc.airirigasi.gettabel') }}", {
                date
            }, function(data, status) {
                $('#data-tabel').html(data);
            });
        }

        $("#form_air_limbah").submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const body = [];
            let date = "";
            const buttonClicked = e.originalEvent.submitter; // To ensure compatibility across browsers
            const actionType = buttonClicked.getAttribute("data-cek");

            if (actionType === "getdata") {
                formData.forEach((value, key) => {
                    if (key == "date_filter") date = value;
                });
                tabel(date);

            } else if (actionType === "savedata") {
                formData.forEach((value, key) => {
                    body[key] = value;
                });

                $.post("{{ route('pencatatan.mc.airirigasi.savedata.post') }}", {
                    ...body
                }, function(data, status) {});
            }
        });
    </script>
@endsection
