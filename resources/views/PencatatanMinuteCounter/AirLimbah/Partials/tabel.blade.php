<table class="table table-responsive-sm text-center min-w-full table-auto">
    <thead class="bg-gray-100">
        <tr class="text-center text-sm">
            <th class="align-middle p-2" rowspan="2">Lokasi</th>
            <th class="align-middle p-2" rowspan="2" style="width: 12%;">Sub Lokasi</th>
            <th class="align-middle p-2" rowspan="2">Pompa Terpasang</th>
            <th class="align-middle p-2" rowspan="2">Pukul</th>
            <th colspan="2" class="p-2">Minute Counter</th>
            <th colspan="2" class="p-2">Vol</th>
            <th colspan="2" class="p-2">Ampere</th>
            <th class="align-middle p-2" rowspan="2">Petugas</th>
            <th class="align-middle p-2" rowspan="2" style="width: 15%;">Keterangan</th>
        </tr>
        <tr class="text-center text-sm">
            <th class="p-2" style="width: 20%;">Terakhir</th>
            <th class="p-2" style="width: 20%;">Sebelumnya</th>
            <th class="p-2" style="width: 5%;">Normal</th>
            <th class="p-2" style="width: 5%;">Tidak Normal</th>
            <th class="p-2" style="width: 5%;">Normal</th>
            <th class="p-2" style="width: 5%;">Tidak Normal</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        @foreach ($datas as $key => $data)
            <tr class="border-b hover:bg-gray-50">
                {{-- Default Value --}}
                <input type="hidden" name="id_{{ $key }}" value="{{ $data?->id ?? '' }}">
                <input type="hidden" name="lokasi_{{ $key }}" value="{{ $data->lokasi }}">
                <input type="hidden" name="sub_lokasi_{{ $key }}" value="{{ $data->sub_lokasi }}">
                <input type="hidden" name="pompa_terpasang_{{ $key }}" value="{{ $data->pompa_terpasang }}">
                <input type="hidden" name="nilai_sebelumnya_{{ $key }}" value="{{ $data->nilai_sebelumnya }}">
                {{-- End Default Value --}}

                @if ($key == 0)
                    <td rowspan="4" class="p-2">{{ $data->lokasi }}</td>
                @elseif ($key == 4 || $key == 7)
                    <td rowspan="3" class="p-2">{{ $data->lokasi }}</td>
                @endif
                <td class="p-2">{{ $data->sub_lokasi }}</td>
                <td class="p-2">{{ $data->pompa_terpasang }}</td>
                <td class="p-2">
                    <input type="time" class="form-control form-control-sm w-24" name="pukul_{{ $key }}"
                        value="{{ $data->pukul }}">
                </td>
                <td class="p-2">
                    <input type="number" class="form-control form-control-sm w-24 text-right"
                        name="nilai_{{ $key }}" value="{{ $data->nilai_terakhir }}">
                </td>
                <td class="p-2 text-right">{{ $data->nilai_sebelumnya }}</td>
                <td class="p-2">
                    <div class="custom-control custom-checkbox checkbox-primary check-xl">
                        <input type="radio" class="custom-control-input" name="volume_{{ $key }}"
                            id="volume_normal_{{ $key }}" {{ $data->volume ? 'checked' : '' }}
                            value="true">
                        <label class="custom-control-label" for="volume_normal_{{ $key }}"></label>
                    </div>
                </td>
                <td class="p-2">
                    <div class="custom-control custom-checkbox checkbox-danger check-xl">
                        <input type="radio" class="custom-control-input" name="volume_{{ $key }}"
                            id="volume_tnormal_{{ $key }}" {{ !$data->volume ? 'checked' : '' }}
                            value="false">
                        <label class="custom-control-label" for="volume_tnormal_{{ $key }}"></label>
                    </div>
                </td>
                <td class="p-2">
                    <div class="custom-control custom-checkbox checkbox-primary check-xl">
                        <input type="radio" class="custom-control-input" name="ampere_{{ $key }}"
                            id="ampere_normal_{{ $key + 1 }}" {{ $data->ampere ? 'checked' : '' }} checked
                            value="true">
                        <label class="custom-control-label" for="ampere_normal_{{ $key + 1 }}"></label>
                    </div>
                </td>
                <td class="p-2">
                    <div class="custom-control custom-checkbox checkbox-danger check-xl">
                        <input type="radio" class="custom-control-input" name="ampere_{{ $key }}"
                            id="ampere_tnormal_{{ $key }}" {{ !$data->volume ? 'checked' : '' }}
                            value="false">
                        <label class="custom-control-label" for="ampere_tnormal_{{ $key }}"></label>
                    </div>
                </td>
                <td class="p-2" style="font-size: 12px;">{{ $data->user }}</td>
                <td class="p-2">
                    <textarea class="form-control form-control-sm" name="keterangan_{{ $key }}">{{ $data->keterangan }}</textarea>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
