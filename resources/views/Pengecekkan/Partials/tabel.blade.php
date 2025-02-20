<table id="tabel-pengecekkan" class="display" style="min-width: 845px">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Catatan</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($customers as $customer)
          <tr>
              <td>{{ $customer->nama }}</td>
              <td>{{ $customer->catatan }}</td>
              <td>
                  @if ($customer->status)
                      <span class="badge badge-pill badge-success">Aktif</span>
                  @else
                      <span class="badge badge-pill badge-danger">Tidak Aktif</span>
                  @endif
              </td>
              <td>
                  <div class="d-flex">
                      <a href="{{ route('master.customer.edit.index', $customer->id) }}"
                          class="btn btn-primary shadow btn-xs sharp mr-1"><i
                              class="fa fa-pencil"></i></a>
                  </div>
              </td>
          </tr>
      @endforeach --}}
    </tbody>
</table>
<script>
    $('#tabel-pengecekkan').DataTable({
        "pageLength": 10,
    });
</script>
