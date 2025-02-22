<div class="basic-form">
    <form id="form-utilitas">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Customer</label>
                <input type="hidden" value='{{ json_encode($customers) }}' id="data_customers">
                <input type="hidden" value='{{ $data?->id ?? '' }}' name="id">
                <select name="customer_id" class="form-control select2" onchange="getCustomer(this.value)"
                    {{ isset($data->id) ? 'disabled' : '' }}>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $val)
                        @if ((!$data?->id && count($val->utilitas) == 0) || $data?->id)
                            <option value="{{ $val->id }}"
                                {{ ($data?->customer_id ?? '') == $val['id'] ? 'selected' : '' }}>
                                {{ $val->nama }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Tipe</label>
                <input type="text" class="form-control" disabled placeholder="Tipe" name="tipe" id="tipe"
                    value="{{ $data?->customer?->group?->type ?? '' }}">
            </div>
            <div class="form-group col-md-6">
                <label>Harga Limbah (Rp)</label>
                <input type="text" class="form-control" disabled placeholder="Harga Limbah" id="harga_limbah"
                    name="harga_limbah" value="{{ $data?->customer?->harga_air_limbah ?? 0 }}">
            </div>
            <div class="form-group col-md-6">
                <label>Harga Air Irigasi (Rp)</label>
                <input type="text" class="form-control" disabled placeholder="Harga Irigasi" name="harga_irigasi"
                    id="harga_irigasi" value="{{ $data?->customer?->harga_air_irigasi ?? 0 }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Sistem Penagihan Air Limbah</label>
                <input type="text" class="form-control" disabled placeholder="Sistem Penagihan Air Limbah"
                    name="penanganan_air_limbah" id="penanganan_air_limbah"
                    value="{{ $data?->customer?->penanganan_air_limbah ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nilai:
                    <span id="nilai_str">
                        {{ $data?->customer?->nilai_str ?? '' }}
                    </span>
                </label>
                <input type="number" class="form-control" placeholder="Nilai" name="nilai"
                    value="{{ $data?->nilai ?? '' }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Customer",
            allowClear: true
        });
    });

    function getCustomer(val) {
        const customers = JSON.parse($("#data_customers").val());
        const customer = customers.filter((item) => (item.id === val))[0] ?? null;

        $("#tipe").val(customer?.group?.type ?? "");
        $("#harga_limbah").val(customer?.harga_air_limbah ?? "");
        $("#harga_irigasi").val(customer?.harga_air_irigasi ?? "");
        $("#penanganan_air_limbah").val(customer?.penanganan_air_limbah ?? "");
        $("#nilai_str").html(customer?.nilai_str ?? "");
    }

    $("#form-utilitas").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const body = [];

        formData.forEach((value, key) => {
            body[key] = value;
        });

        $.post("{{ route('pengecekkan.airlimbah.savedata.post') }}", {
            ...body
        }, function(data, status) {
            if (status == "success") {
                const customers = JSON.parse($("#data_customers").val());
                const qty = customers.filter((item) => (item.utilitas.length > 0)).length + 1;
                const customer = customers.filter((item) => (item.id === body.customer_id))[0] ?? null;

                if (!body?.id && body?.id != "") {
                    if (qty == 1) $("#tabel-pengecekkan-al tbody tr:first").remove();
                    let link = "{{ route('pengecekkan.airlimbah.form', ['id' => '__ID__']) }}";
                    link = link.replace('__ID__', data.id);

                    $("#tabel-pengecekkan-al tbody").append(`
                        <tr>
                            <td>${qty}</td>
                            <td>${customer.nama}</td>
                            <td>${customer.group.type}</td>
                            <td class="text-right">${customer.harga_air_limbah ?? 0}</td>
                            <td class="text-right">${customer.harga_air_irigasi ?? 0}</td>
                            <td>${customer.penanganan_air_limbah}</td>
                            <td class="text-right">${customer.nilai_str}: ${body.nilai}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1" 
                                        onclick="Modal('${link}', 'modal-lg', 'Edit Data')">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `);
                }

                $('#Modal').modal('hide');
            }
        });
    });
</script>
