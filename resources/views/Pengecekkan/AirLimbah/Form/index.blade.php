<style>
    .select2-container--bootstrap-5 .select2-selection {
        min-height: calc(2.4em + .77rem + 3px) !important;
        border-radius: 0.65rem !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 2.5 !important;
    }
</style>
<div class="basic-form">
    <form id="form-utilitas">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Customer</label>
                <input type="hidden" value='{{ json_encode($customers) }}' id="data_customers">
                <input type="hidden" value='{{ $data?->id ?? '' }}' name="id">

                @if (isset($data->id) && $data->id != '')
                    <input type="hidden" value='{{ $data?->customer_id ?? '' }}' name="customer_id">
                    <input type="text" class="form-control" value='{{ $data?->customer?->nama ?? '' }}' disabled>
                @else
                    <select name="customer_id" class="select2" onchange="getCustomer(this.value)"
                        {{ isset($data->id) ? 'disabled' : '' }}>
                        <option value="">-- Pilih Customer --</option>
                        @foreach ($customers as $val)
                            @if ((!$data?->id && count($val->utilitas) == 0) || $data?->id)
                                <option value="{{ $val->id }}"
                                    {{ ($data?->customer_id ?? '') == $val->id ? 'selected' : '' }}>
                                    {{ $val->nama }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                @endif

            </div>
            <div class="form-group col-md-6">
                <label>Tipe</label>
                <input type="text" class="form-control" disabled placeholder="Tipe" name="tipe" id="tipe"
                    value="{{ $data?->customer?->group?->type ?? '' }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Harga Limbah (Rp)</label>
                <input type="text" class="form-control" disabled placeholder="Harga Limbah" id="harga_limbah"
                    name="harga_limbah" value="{{ $data?->customer?->harga_air_limbah ?? 0 }}">
            </div>
            {{-- <div class="form-group col-md-6">
                <label>Harga Air Irigasi (Rp)</label>
                <input type="text" class="form-control" disabled placeholder="Harga Irigasi" name="harga_irigasi"
                    id="harga_irigasi" value="{{ $data?->customer?->harga_air_irigasi ?? 0 }}">
            </div> --}}
            <div class="form-group col-md-4">
                <label>Type Perhitungan</label>
                <input type="text" class="form-control" disabled placeholder="Type Perhitungan"
                    name="type_perhitungan" id="type_perhitungan"
                    value="{{ $data?->customer?->type_perhitungan ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label>Perhitungan</label>
                <input type="text" class="form-control" disabled placeholder="Perhitungan" name="perhitungan"
                    id="perhitungan" value="{{ $data?->customer?->perhitungan ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Pemakaian:
                    <span id="nilai_str">
                        {{ $data?->customer?->nilai_str ?? '' }}
                    </span>
                </label>
                <input type="number" class="form-control" placeholder="Pemakaian" name="nilai"
                    value="{{ $data?->nilai ?? '' }}" required autocomplete="off">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Customer",
            allowClear: true,
            theme: "bootstrap-5"
        });
    });

    function getCustomer(val) {
        const customers = JSON.parse($("#data_customers").val());
        const customer = customers.filter((item) => (item.id === val))[0] ?? null;

        $("#tipe").val(customer?.group?.type ?? "");
        $("#harga_limbah").val(customer?.harga_air_limbah ?? "");
        $("#harga_irigasi").val(customer?.harga_air_irigasi ?? "");
        $("#type_perhitungan").val(customer?.type_perhitungan ?? "");
        $("#perhitungan").val(customer?.perhitungan ?? "");
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

                if (body?.id == "") {

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
                            <td>${customer.perhitungan}</td>
                            <td class="text-right">${customer.type_perhitungan}: ${body.nilai}</td>
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
                } else {
                    $(`#nilai_${body.id}`).html(`${customer.type_perhitungan}: ${body.nilai}`);
                }
            }

            $('#Modal').modal('hide');
        });
    });
</script>
