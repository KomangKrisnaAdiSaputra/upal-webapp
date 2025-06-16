<table id="tabel-pencatatan-ai" class="table table-responsive-sm text-center min-w-full table-auto">
    <thead class="bg-gray-100">
        <tr class="text-center text-sm">
            <th class="align-middle p-2" rowspan="2">#</th>
            <th class="align-middle p-2" rowspan="2">Konsumen</th>
            <th class="align-middle p-2" colspan="2">Pembacaan Meteran (M<sup>3</sup>)</th>
            <th class="align-middle p-2" rowspan="2">Pemakaian (M<sup>3</sup>)</th>
            <th class="align-middle p-2" rowspan="2">Keterangan</th>
            <th class="align-middle p-2" rowspan="2">Petugas</th>
            <th class="align-middle p-2" rowspan="2">Action</th>
        </tr>
        <tr class="text-center text-sm">
            <th class="align-middle p-2">Terakhir</th>
            <th class="align-middle p-2">Sebelumnya</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        @foreach ($datas as $data)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $data->konsumen }}</td>
                <td class="text-right" id="nilai_terakhir_{{ $data->id }}">{{ $data->nilai_terakhir }}</td>
                <td class="text-right">{{ $data->nilai_sebelumnya }}</td>
                <td class="text-right" id="pemakaian_{{ $data->id }}">{{ $data->pemakaian }}</td>
                <td>{{ $data->keterangan }}</td>
                <td class="text-right">
                    {{ $data->user }}
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="#"
                            class="btn btn-primary shadow btn-xs sharp mr-1"onclick="handleEdit('{{ $data->id }}')">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $('#tabel-pencatatan-ai').DataTable({
        "pageLength": 10,
    });

    function handleEdit(id) {
        console.log("huhu");

        const date = $("#date").val();

        let link = `{!! route('pencatatan.airirigasi.form', ['date' => '__DATE__', 'id' => '__ID__']) !!}`;
        link = link.replace('__DATE__', date);
        link = link.replace('__ID__', id);

        Modal(link, 'modal-lg', 'Edit Data')
    }
</script>
