<table id="tabel-pengecekkan-al" class="table table-responsive-sm text-center min-w-full table-auto">
    <thead class="bg-gray-100">
        <tr class="text-center text-sm">
            <th class="align-middle p-2" rowspan="2">#</th>
            <th class="align-middle p-2" rowspan="2">Konsumen</th>
            <th class="align-middle p-2" rowspan="2">Tipe Konsumen</th>
            <th class="align-middle p-2" colspan="2">Harga</th>
            <th class="align-middle p-2" rowspan="2">Sistem Penagihan Air Limbah</th>
            <th class="align-middle p-2" rowspan="2">Nilai</th>
            <th class="align-middle p-2" rowspan="2">Action</th>
        </tr>
        <tr class="text-center text-sm">
            <th class="align-middle p-2">Air Limbah (Rp)</th>
            <th class="align-middle p-2">Air Irigasi (Rp)</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        <tr>
            @for ($i = 0; $i < 8; $i++)
                <td>{{ $i }}</td>
            @endfor
        </tr>
    </tbody>
</table>
<script>
    $('#tabel-pengecekkan-al').DataTable({
        "pageLength": 10,
    });
</script>
