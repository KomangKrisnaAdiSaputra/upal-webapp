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
                <input type="hidden" id="data_customers">
                <input type="hidden" value='{{ Carbon\Carbon::today()->toDateString() }}' id="today">
                <input type="hidden" value='{{ Carbon\Carbon::today()->subDay()->toDateString() }}' id="yesterday">
                <input type="hidden" value='{{ $data?->id ?? '' }}' name="id">
                <input type="hidden" value='{{ auth()?->user()?->nama ?? '' }}' name="user">
                @if (isset($data->id) && $data->id != '')
                    <input type="hidden" value='{{ $data?->customer_id ?? '' }}' name="customer_id">
                    <input type="text" class="form-control" value='{{ $data?->customer?->nama ?? '' }}' disabled>
                @else
                    <select name="customer_id" id="customer-list" class="select2" onchange="getCustomer(this.value)"
                        disabled>
                    </select>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label fw-medium" for="date">Tanggal</label>
                <input type="date" name="date" id="date-select"
                    value="{{ $data?->tanggal ?? Carbon\Carbon::today()->toDateString() }}"
                    class="form-control py-2 px-3 border rounded-md">
            </div>
            <div class="form-group col-md-4">
                <label>Meteran Terakhir (M<sup>3</sup>)</label>
                <input type="number" class="form-control" placeholder="meteran terakhir" name="nilai_terakhir"
                    id="nilai_terakhir" value="{{ $data?->nilai ?? '' }}" onchange="nilai(this.value)" step="any">
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
            const yesterday = $("#yesterday").val();
            const customers = JSON.parse($("#data_customers").val());
            const customer = customers.find(item => item.id == val) ?? null;
            const nilai_terakhir = $("#nilai_terakhir").val();
            const nilai_sebelumnya = customer?.utilitas?.find(item => item.tanggal == yesterday)?.nilai ?? 0;

            $("#nilai_sebelumnya").val(nilai_sebelumnya);
            $("#pemakaian").val(nilai_terakhir - nilai_sebelumnya);
        };

        // Event saat nilai diubah
        window.nilai = function(val) {
            const nilai_sebelumnya = $("#nilai_sebelumnya").val();
            $("#pemakaian").val(val - nilai_sebelumnya);
        };



        // Fungsi untuk ambil customer dari backend
        function fetchCustomers(date) {
            customerList.setAttribute('disabled', 'disabled');

            $.post("{{ route('pencatatan.airirigasi.customers.post') }}", {
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

    // Submit form
    $("#form-utilitas").off('submit').on("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const body = {};

        formData.forEach((value, key) => {
            body[key] = value;
        });

        $.post("{{ route('pencatatan.airirigasi.savedata.post') }}", body, function(data, status) {
            if (status === "success") {
                tabel("{{ $date }}");
                $('#Modal').modal('hide');
            }
        });
    });
</script>
