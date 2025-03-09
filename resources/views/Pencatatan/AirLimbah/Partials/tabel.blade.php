<table id="tabel-pencatatan-al" class="table table-responsive-sm text-center min-w-full table-auto">
    <thead class="bg-gray-100">
        {{-- <tr class="text-center text-sm">
            <th class="align-middle p-2" rowspan="2">#</th>
            <th class="align-middle p-2" rowspan="2">Konsumen</th>
            <th class="align-middle p-2" rowspan="2">Tipe Konsumen</th>
            <th class="align-middle p-2" colspan="2">Harga</th>
            <th class="align-middle p-2" rowspan="2">Perhitungan</th>
            <th class="align-middle p-2" rowspan="2">Pemakaian</th>
            <th class="align-middle p-2" rowspan="2">Action</th>
        </tr>
        <tr class="text-center text-sm">
            <th class="align-middle p-2">Air Limbah (Rp)</th>
            <th class="align-middle p-2">Air Irigasi (Rp)</th>
        </tr> --}}
        <tr class="text-center text-sm">
            <th class="align-middle p-2">#</th>
            <th class="align-middle p-2">Konsumen</th>
            <th class="align-middle p-2">Tipe Konsumen</th>
            <th class="align-middle p-2">Harga</th>
            <th class="align-middle p-2">Koefisien</th>
            <th class="align-middle p-2">Pemakaian</th>
            <th class="align-middle p-2">Action</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        @foreach ($datas as $data)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $data->customer->nama }}</td>
                <td>{{ $data->customer->group->type }}</td>
                <td class="text-right">{{ $data->customer->harga_air_limbah ?? 0 }}</td>
                {{-- <td class="text-right">{{ $data->customer->harga_air_irigasi ?? 0 }}</td> --}}
                <td>{{ $data->customer->perhitungan }}</td>
                <td class="text-right" id="nilai_{{ $data->id }}">
                    {{ $data->customer->type_perhitungan . ': ' . $data->nilai }}
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="#"
                            class="btn btn-primary shadow btn-xs sharp mr-1"onclick="Modal('{{ route('pencatatan.airlimbah.form', ['id' => $data->id]) }}', 'modal-lg', 'Edit Data')">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $('#tabel-pencatatan-al').DataTable({
        "pageLength": 10,
    });
</script>
