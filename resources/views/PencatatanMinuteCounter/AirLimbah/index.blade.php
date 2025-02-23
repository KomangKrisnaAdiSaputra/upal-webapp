@extends('layouts.main')
@section('title', 'Pencatatan Minute Counter Air Limbah')

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
                <h4 class="card-title">Data Air Limbah</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="#" id="form_air_limbah">
                        <div class="d-flex align-items-center mb-4">
                            <!-- Tanggal Input Section -->
                            <div class="d-flex align-items-center me-4">
                                <label for="Tanggal" class="form-label me-2">Tanggal</label>
                                <input type="date" name="date_filter"
                                    value="{{ Carbon\Carbon::today()->toDateString() }}"
                                    class="form-control py-2 px-3 border rounded-3">
                            </div>

                            <!-- Button Group -->
                            <div class="d-flex gap-3">
                                <button type="submit" data-cek="getdata"
                                    class="btn btn-primary py-2 px-4 rounded-3 hover:bg-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                    Tampilkan
                                </button>
                                <button type="submit" data-cek="savedata"
                                    class="flex btn btn-success py-2 px-4 rounded-3 hover:bg-success focus:outline-none focus:ring-2 focus:ring-success"
                                    style="display: flex;">
                                    <span>Simpan</span>
                                    <span id="btn-simpan" style="margin: 2px 0 0 5px;" />
                                </button>
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
            $('#data-tabel').html(spinner());

            $.get("{{ route('pencatatan.mc.airlimbah.gettabel') }}", {
                date
            }, function(data, status) {
                setTimeout(() => {
                    $('#data-tabel').html(data);
                }, 1000);
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

                $("#btn-simpan").html(spinner("text-white", "1rem", "1rem"));

                $.post("{{ route('pencatatan.mc.airlimbah.savedata.post') }}", {
                    ...body
                }, function(data, status) {
                    setTimeout(() => {
                        $("#btn-simpan").html("");
                    }, 1000);
                });
            }
        });
    </script>
@endsection
