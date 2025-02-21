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
                    <form action="#">
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

                        <table class="table table-responsive-sm text-center min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr class="text-center text-sm">
                                    <th class="align-middle p-2" rowspan="2">Lokasi</th>
                                    <th class="align-middle p-2" rowspan="2" style="width: 12%;">Sub Lokasi</th>
                                    <th class="align-middle p-2" rowspan="2">Pompa Terpasang</th>
                                    <th class="align-middle p-2" rowspan="2">Pukul</th>
                                    <th colspan="2" class="p-2">Minute Counter</th>
                                    <th colspan="2" class="p-2">Vol</th>
                                    <th colspan="2" class="p-2">Ampere</th>
                                    <th class="align-middle p-2" rowspan="2">Petugas</th>
                                    <th class="align-middle p-2" rowspan="2" style="width: 15%;">Keterangan</th>
                                </tr>
                                <tr class="text-center text-sm">
                                    <th class="p-2" style="width: 20%;">Terakhir</th>
                                    <th class="p-2" style="width: 20%;">Sebelumnya</th>
                                    <th class="p-2" style="width: 5%;">Normal</th>
                                    <th class="p-2" style="width: 5%;">Tidak Normal</th>
                                    <th class="p-2" style="width: 5%;">Normal</th>
                                    <th class="p-2" style="width: 5%;">Tidak Normal</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach ($datas as $key => $data)
                                    <tr class="border-b hover:bg-gray-50">
                                        @if ($key == 0)
                                            <td rowspan="4" class="p-2">{{ $data->lokasi }}</td>
                                        @elseif ($key == 4 || $key == 7)
                                            <td rowspan="3" class="p-2">{{ $data->lokasi }}</td>
                                        @endif
                                        <td class="p-2">{{ $data->sub_lokasi }}</td>
                                        <td class="p-2">{{ $data->pompa_terpasang }}</td>
                                        <td class="p-2">
                                            <input type="time" class="form-control form-control-sm w-24">
                                        </td>
                                        <td class="p-2">
                                            <input type="number" class="form-control form-control-sm w-24 text-right"
                                                name="nilai">
                                        </td>
                                        <td class="p-2 text-right">{{ $data->nilai_sebelumnya }}</td>
                                        <td class="p-2">
                                            <div class="custom-control custom-checkbox checkbox-primary check-xl">
                                                <input type="checkbox" class="custom-control-input" checked
                                                    id="volume_normal">
                                                <label class="custom-control-label" for="volume_normal"></label>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="custom-control custom-checkbox checkbox-danger check-xl">
                                                <input type="checkbox" class="custom-control-input" checked
                                                    id="volume_tnormal">
                                                <label class="custom-control-label" for="volume_tnormal"></label>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="custom-control custom-checkbox checkbox-primary check-xl">
                                                <input type="checkbox" class="custom-control-input" checked
                                                    id="ampere_normal">
                                                <label class="custom-control-label" for="ampere_normal"></label>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="custom-control custom-checkbox checkbox-danger check-xl">
                                                <input type="checkbox" class="custom-control-input" checked
                                                    id="ampere_tnormal">
                                                <label class="custom-control-label" for="ampere_tnormal"></label>
                                            </div>
                                        </td>
                                        <td class="p-2" style="font-size: 12px;">I Komang Krisna Adi Saputra</td>
                                        <td class="p-2">
                                            <textarea class="form-control form-control-sm" placeholder=""></textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Menangani event submit
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form untuk submit secara default

            // Ambil tanggal dari input type date
            const tanggal = document.querySelector('input[type="date"]').value;

            // Ambil semua baris tabel
            const rows = document.querySelectorAll('tbody tr');
            const tableData = [];

            rows.forEach(row => {
                // Ambil data dalam setiap baris tabel
                const lokasi = row.querySelector('td:nth-child(1)').textContent;
                const subLokasi = row.querySelector('td:nth-child(2)').textContent;
                const pompaTerpasang = row.querySelector('td:nth-child(3)').textContent;
                const waktu = row.querySelector('input[type="time"]').value;
                const terahir = row.querySelector('td:nth-child(5) input[type="number"]')?.value ?? "";
                const sebelumnya = row.querySelector('td:nth-child(6)').textContent;
                const volumeNormal = row.querySelector('input#volume_normal').checked;
                const volumeTnormal = row.querySelector('input#volume_tnormal').checked;
                const ampereNormal = row.querySelector('input#ampere_normal').checked;
                const ampereTnormal = row.querySelector('input#ampere_tnormal').checked;
                const petugas = row.querySelector('td:nth-child(10)').textContent;
                const keterangan = row.querySelector('textarea').value;

                // Masukkan data baris ke dalam array
                tableData.push({
                    lokasi,
                    subLokasi,
                    pompaTerpasang,
                    waktu,
                    terahir,
                    sebelumnya,
                    volumeNormal,
                    volumeTnormal,
                    ampereNormal,
                    ampereTnormal,
                    petugas,
                    keterangan
                });
            });

            // Kirim data ke server atau tampilkan di console
            const formData = {
                tanggal,
                tableData
            };

            console.log(formData); // Atau gunakan AJAX untuk mengirimkan formData ke server

            // Anda dapat menggunakan fetch atau AJAX di sini untuk mengirim formData ke backend
        });
    </script>

@endsection
