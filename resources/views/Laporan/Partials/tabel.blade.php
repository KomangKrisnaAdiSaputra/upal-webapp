<table id="tabel-laporan" class="table table-bordered table-hover table-striped text-center align-middle">
    <thead class="table-light">
        <tr class="text-sm">
            <th rowspan="2">#</th>
            <th rowspan="2">Konsumen</th>
            <th colspan="2">Program Kerja <span id="pk_tahun"></span></th>
            <th colspan="2">Realisasi <span id="rl_tahun"></span></th>
            <th colspan="2">%Real/Progja</th>
            <th colspan="2">Realisasi <span id="rl2_tahun"></span></th>
            <th colspan="2">%Real <span id="real_tahun"></span></th>
        </tr>
        <tr class="text-sm">
            <th>1</th>
            <th>s/d <span class="data-tahun">2</span></th>
            <th>3</th>
            <th>s/d <span class="data-tahun">4</span></th>
            <th>5</th>
            <th>s/d <span class="data-tahun">6</span></th>
            <th>7</th>
            <th>s/d <span class="data-tahun">8</span></th>
            <th>9</th>
            <th>s/d <span class="data-tahun">10</span></th>
        </tr>
    </thead>
    <tbody class="table-group-divider text-sm">
        @foreach ($datas as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data->pk_1 }}</td>
                <td>{{ $data->pk_2 }}</td>
                <td>{{ $data->rl_1 }}</td>
                <td>{{ $data->rl_2 }}</td>
                <td>{{ $data->rp_1 }}</td>
                <td>{{ $data->rp_2 }}</td>
                <td>{{ $data->_rl_1 }}</td>
                <td>{{ $data->_rl_2 }}</td>
                <td>{{ $data->real_1 }}</td>
                <td>{{ $data->real_2 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#tabel-laporan').DataTable({
        "pageLength": 10,
    });
</script>
