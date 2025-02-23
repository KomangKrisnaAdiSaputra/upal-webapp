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
            <div class="form-group col-md-12">
                <label>Customer</label>
                <input type="hidden" value='{{ json_encode($customers) }}' id="data_customers">
                <input type="hidden" value='{{ Carbon\Carbon::today()->toDateString() }}' id="today">
                <input type="hidden" value='{{ Carbon\Carbon::today()->subDay()->toDateString() }}' id="yesterday">
                <input type="hidden" value='{{ $data?->id ?? '' }}' name="id">
                <input type="hidden" value='{{ auth()?->user()?->nama ?? '' }}' name="user">
                @if (isset($data->id) && $data->id != '')
                    <input type="hidden" value='{{ $data?->customer_id ?? '' }}' name="customer_id">
                    <input type="text" class="form-control" value='{{ $data?->customer?->nama ?? '' }}' disabled>
                @else
                    <select name="customer_id" class="select2" onchange="getCustomer(this.value)"
                        {{ isset($data->id) ? 'disabled' : '' }}>
                        <option value="">-- Pilih Customer --</option>
                        @foreach ($customers as $val)
                            @php
                                $today = Carbon\Carbon::today()->toDateString();
                                $utilitas_today = $val->utilitas->where('tanggal', $today)->first();
                            @endphp
                            @if (!$utilitas_today)
                                <option value="{{ $val->id }}"
                                    {{ ($data?->customer_id ?? '') == $val->id ? 'selected' : '' }}>
                                    {{ $val->nama }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                @endif

            </div>
            <div class="form-group col-md-4">
                <label>Meteran Terakhir (M<sup>3</sup>)</label>
                <input type="number" class="form-control" placeholder="meteran terakhir" name="nilai_terakhir"
                    id="nilai_terakhir" value="{{ $data?->nilai ?? '' }}" onchange="nilai(this.value)">
            </div>
            <div class="form-group col-md-4">
                <label>Meteran Sebelumnya (M<sup>3</sup>)</label>
                <input type="text" class="form-control" readonly placeholder="meteran sebelumnya"
                    id="nilai_sebelumnya" name="nilai_sebelumnya" value="{{ $old?->nilai ?? 0 }}">
            </div>
            <div class="form-group col-md-4">
                <label>Pemakaian (M<sup>3</sup>)</label>
                <input type="text" class="form-control" readonly placeholder="pemakaian" name="pemakaian"
                    id="pemakaian" value="{{ ($data?->nilai ?? 0) - ($old?->nilai ?? 0) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Keterangan</label>
                <textarea class="form-control form-control-sm" name="keterangan">{{ $data?->keterangan ?? '' }}</textarea>

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
        const today = $("#today").val();
        const yesterday = $("#yesterday").val();
        const customers = JSON.parse($("#data_customers").val());
        const customer = customers.filter((item) => (item.id === val))[0] ?? null;
        const nilai_terakhir = $("#nilai_terakhir").val();

        const nilai_sebelumnya = customer?.utilitas?.filter((item) => (item.tanggal == yesterday))[0]?.nilai ?? 0;

        $("#nilai_sebelumnya").val(nilai_sebelumnya);
        $("#pemakaian").val(nilai_terakhir - nilai_sebelumnya);
    }

    function nilai(val) {
        const nilai_sebelumnya = $("#nilai_sebelumnya").val();
        $("#pemakaian").val(val - nilai_sebelumnya);
    }

    $("#form-utilitas").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const body = [];
        const today = $("#today").val();
        const yesterday = $("#yesterday").val();

        formData.forEach((value, key) => {
            body[key] = value;
        });

        $.post("{{ route('pengecekkan.airirigasi.savedata.post') }}", {
            ...body
        }, function(data, status) {
            if (status == "success") {
                const customers = JSON.parse($("#data_customers").val());
                const qty = customers.filter((item) => (item.utilitas.filter((ut) => ut.tanggal ===
                        today)
                    .length > 0)).length + 1;
                const customer = customers.filter((item) => (item.id === body.customer_id))[0] ?? null;

                if (body?.id == "") {
                    if (qty == 1) $("#tabel-pengecekkan-ai tbody tr:first").remove();
                    let link = "{{ route('pengecekkan.airirigasi.form', ['id' => '__ID__']) }}";
                    link = link.replace('__ID__', data.id);

                    $("#tabel-pengecekkan-ai tbody").append(`
                           <tr>
                                <td>${qty}</td>
                                <td>${customer.nama}</td>
                                <td class="text-right">${body.nilai_terakhir}</td>
                                <td class="text-right">${body.nilai_sebelumnya}</td>
                                <td class="text-right">${body.pemakaian}</td>
                                <td>${body.keterangan}</td>
                                <td class="text-right">
                                    ${body.user}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="#"
                                            class="btn btn-primary shadow btn-xs sharp mr-1"onclick="Modal('${link}', 'modal-lg', 'Edit Data')">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                           </tr>
                    `);
                } else {
                    $(`#nilai_terakhir_${body.id}`).html(body.nilai_terakhir);
                    $(`#pemakaian_${body.id}`).html(body.nilai_terakhir - body.nilai_sebelumnya);
                }
            }

            $('#Modal').modal('hide');
        });

    });
</script>
