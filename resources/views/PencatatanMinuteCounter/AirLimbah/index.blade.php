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
                        <div class="flex items-center space-x-4 mb-6">
                            <!-- Tanggal Input Section -->
                            <div class="flex items-center space-x-2">
                                <label class="form-label text-sm font-medium" for="Tanggal">Tanggal</label>
                                <input type="date" name="" id=""
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

        function tabel() {
            $.get("{{ route('pencatatan.mc.airlimbah.gettabel') }}", {}, function(data, status) {
                $('#data-tabel').html(data);
            });
        }

        $("#form_air_limbah").submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const body = [];
            const buttonClicked = e.originalEvent.submitter; // To ensure compatibility across browsers
            const actionType = buttonClicked.getAttribute("data-cek");

            console.log(actionType);


            if (actionType === "getdata") {

            } else if (actionType === "savedata") {}
            formData.forEach((value, key) => {
                body[key] = value;
            });

            $.post("{{ route('pencatatan.mc.airlimbah.savedata.post') }}", {
                ...body
            }, function(data, status) {
                console.log(data);
            });
        });

        // document.getElementById("form_air_limbah").addEventListener("submit", function(event) {
        //     event.preventDefault(); 
        //     const buttonClicked = event.submitter; 
        //     const actionType = buttonClicked.getAttribute("data-cek");// Ambil atribut data-cek

        //     const formData = [];
        //     const rows = document.querySelectorAll("tbody tr");

        //     if (actionType === "getdata") {

        //     } else if (actionType === "savedata") {
        //         rows.forEach(row => {
        //             const data = {
        //                 lokasi: row.querySelector('input[name="lokasi"]')?.value || "",
        //                 sub_lokasi: row.querySelector('input[name="sub_lokasi"]')?.value || "",
        //                 pompa_terpasang: row.querySelector('input[name="pompa_terpasang"]')?.value ||
        //                     "",
        //                 pukul: row.querySelector('input[name="pukul"]')?.value || "",
        //                 nilai: row.querySelector('input[name="nilai"]')?.value || "",
        //                 nilai_sebelumnya: row.querySelector('input[name="nilai_sebelumnya"]')?.value ||
        //                     "",
        //                 volume: row.querySelector('#volume_normal')?.checked || false,
        //                 ampere: row.querySelector('input[name="ampere"]')?.checked || false,
        //                 petugas: row.cells[row.cells.length - 2]?.textContent.trim() || "",
        //                 keterangan: row.querySelector('textarea[name="keterangan"]')?.value || ""
        //             };

        //             formData.push(data);
        //         });

        //         $.post("{{ route('pencatatan.mc.airlimbah.savedata.post') }}", {
        //             datas: formData
        //         }, function(data, status) {
        //             console.log(data);
        //         });
        //     }
        // });
    </script>

@endsection
