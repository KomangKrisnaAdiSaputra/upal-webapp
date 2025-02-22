<div class="basic-form">
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Customer</label>
                <select name="customer_id" class="form-control select2">
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $val)
                        <option value="{{ $val->id }}"
                            {{ $utilitas?->customer_id ?? '' == $val['id'] ? 'selected' : '' }}>
                            {{ $val->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Tipe</label>
                <input type="text" class="form-control custom-disabled" placeholder="Tipe" name="tipe">
            </div>
            <div class="form-group col-md-6">
                <label>Harga Limbah (Rp)</label>
                <input type="text" class="form-control custom-disabled" placeholder="Harga Limbah"
                    name="harga_limbah">
            </div>
            <div class="form-group col-md-6">
                <label>Harga Air Irigasi (Rp)</label>
                <input type="text" class="form-control custom-disabled" placeholder="Harga Irigasi"
                    name="harga_irigasi">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Sistem Penagihan Air Limbah</label>
                <input type="text" class="form-control custom-disabled" placeholder="Sistem Penagihan Air Limbah"
                    name="penanganan_air_limbah">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nilai: </label>
                <input type="number" class="form-control" placeholder="Nilai" name="nilai" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Customer",
            allowClear: true
        });
    });
</script>
