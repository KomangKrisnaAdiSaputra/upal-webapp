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
            <div class="form-group col-md-4">
                <label>Customer</label>
                <input type="hidden" id="data_customers">
                <input type="hidden" value='{{ $data?->id ?? '' }}' name="id">

                @if (isset($data->id) && $data->id != '')
                    <input type="hidden" value='{{ $data?->customer_id ?? '' }}' name="customer_id">
                    <input type="text" class="form-control" value='{{ $data?->customer?->nama ?? '' }}' disabled>
                @else
                    <select name="customer_id" id="customer-list" class="select2" onchange="getCustomer(this.value)">
                    </select>
                @endif

            </div>
            <div class="form-group col-md-4">
                <label class="form-label fw-medium" for="date">Bulan</label>
                <input type="month" name="date" id="date-select"
                    value="{{ Carbon\Carbon::parse($data?->tanggal ?? Carbon\Carbon::now()->toDateString())->format('Y-m') }}"
                    class="form-control py-2 px-3 border rounded-md">
            </div>
            <div class="form-group col-md-4">
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
                <label>Koefisien</label>
                <input type="text" class="form-control" disabled placeholder="Koefisien" name="perhitungan"
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
                    value="{{ $data?->nilai ?? '' }}" required autocomplete="off" step="any">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>
    function initUtilitasForm() {
        const dateSelect = document.getElementById('date-select');
        const customerList = document.getElementById('customer-list');
        const isEditMode = "{{ isset($data->id) && $data->id != '' ? '1' : '0' }}";

        if (!dateSelect || !customerList) return;

        // Inisialisasi select2
        $('.select2').select2({
            placeholder: "Pilih Customer",
            allowClear: true,
            theme: "bootstrap-5"
        });

        // Jika bukan edit mode, fetch customer berdasarkan tanggal
        if (isEditMode !== '1') {
            fetchCustomers(dateSelect.value);

            // Event saat ganti tanggal
            dateSelect.addEventListener("change", function() {
                fetchCustomers(this.value);
            });
        }

        // Event ketika memilih customer
        window.getCustomer = function(val) {
            const customers = JSON.parse($("#data_customers").val());
            const customer = customers.filter((item) => (item.id === val))[0] ?? null;

            $("#tipe").val(customer?.group?.type ?? "");
            $("#harga_limbah").val(customer?.harga_air_limbah ?? "");
            $("#harga_irigasi").val(customer?.harga_air_irigasi ?? "");
            $("#type_perhitungan").val(customer?.type_perhitungan ?? "");
            $("#perhitungan").val(customer?.perhitungan ?? "");
            $("#nilai_str").html(customer?.nilai_str ?? "");
        };

        // Fungsi untuk ambil customer dari backend
        function fetchCustomers(date) {
            customerList.setAttribute('disabled', 'disabled');

            $.post("{{ route('pencatatan.airlimbah.customers.post') }}", {
                date
            }, function(data, status) {
                const customers = data?.customers ?? [];
                let options = "<option value=''>Pilih Customer</option>";

                $("#data_customers").val(JSON.stringify(customers));

                const selectedId = "{{ $data?->customer_id ?? '' }}";
                customers.forEach((customer) => {
                    const selected = selectedId == customer.id ? 'selected' : '';
                    options += `<option value="${customer.id}" ${selected}>${customer.nama}</option>`;
                });

                customerList.innerHTML = options;
                $('#customer-list').val(null).trigger('change');
                customerList.removeAttribute('disabled');
            });
        }
    }

    // Jalankan hanya saat modal muncul
    $('#Modal').on('shown.bs.modal', function() {
        initUtilitasForm();
    });

    $("#form-utilitas").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const body = [];

        formData.forEach((value, key) => {
            body[key] = value;
        });

        $.post("{{ route('pencatatan.airlimbah.savedata.post') }}", {
            ...body
        }, function(data, status) {
            if (status == "success") {
                tabel('{{ $date }}');

            }

            $('#Modal').modal('hide');
        });
    });
</script>
