<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemakaian Air Irigasi</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-size: 10pt;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            text
        }

        .header {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

@php
    $header_arr = ['Nomor Dokumen', 'Revisi', 'Tanggal Efektif', 'Penanggung Jawab', 'Pelaksana', 'Di Buat Oleh'];
    $total_terakhir = 0;
    $total_sebelumnya = 0;
    $total_pemakaian = 0;
@endphp

<body>
    <div class="container">
        <table class="header">
            <tr>
                <td style="text-align: center; width: 40%;">
                    <img src="data:image/png;base64,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"
                        alt="">
                </td>
                <td style="text-align: left">
                    <table>
                        @foreach ($header_arr as $header)
                            <tr>
                                <td>{{ $header }}</td>
                                <td> :</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 10px;" class="uppercase">
            <h1>check list harian pemakaian air irigasi</h1>
        </div>

        <table style="margin-top: 50px;">
            <tr>
                <td class="uppercase">Tahun</td>
                <td> : </td>
                <td>{{ $tahun }}</td>
            </tr>
            <tr>
                <td class="uppercase">Hari/tgl/bulan</td>
                <td>:</td>
                <td>{{ $tanggal }}</td>
            </tr>
        </table>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
            <thead>
                <tr style="background-color: #f3f4f6;">
                    <th rowspan="2" style="border: 1px solid #d1d5db;  text-align: center;">No</th>
                    <th rowspan="2" style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">
                        Konsumen</th>
                    <th colspan="2" style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">
                        Pembacaan Meteran (M<sup>3</sup>)</th>
                    <th rowspan="2" style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">
                        Pemakaian (M<sup>3</sup>)</th>
                    <th rowspan="2" style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">
                        Keterangan</th>
                    <th rowspan="2" style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">Petugas
                    </th>
                </tr>
                <tr style="background-color: #f3f4f6;">
                    <th style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">Terakhir</th>
                    <th style="border: 1px solid #d1d5db; padding: 8px 16px; text-align: center;">Sebelumnya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_irigasi as $irigasi)
                    @foreach ($irigasi->datas as $key => $data)
                        <tr style="background-color: white; transition: background-color 0.3s;">
                            <td style="border: 1px solid #d1d5db; padding: 8px 16px">{{ $key + 1 }}</td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 16px;">{{ $data->customer }}</td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                                {{ $data->nilai_terakhir }}
                            </td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                                {{ $data->nilai_sebelumnya }}
                            </td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                                {{ $data->pemakaian }}
                            </td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 16px;">{{ $data->keterangan }}</td>
                            <td style="border: 1px solid #d1d5db; padding: 8px 16px;">{{ $data->user }}</td>
                        </tr>
                    @endforeach
                    @php
                        $_totalTerakhir = collect($irigasi->datas)->pluck('nilai_terakhir')->sum();
                        $_totalSebelumnya = collect($irigasi->datas)->pluck('nilai_sebelumnya')->sum();
                        $_totalPemakaian = collect($irigasi->datas)->pluck('pemakaian')->sum();

                        $total_terakhir += $_totalTerakhir;
                        $total_sebelumnya += $_totalSebelumnya;
                        $total_pemakaian += $_totalPemakaian;
                    @endphp
                    <tr style="background-color: white; transition: background-color 0.3s;">
                        <td style="border: 1px solid #d1d5db;"></td>
                        <td style="border: 1px solid #d1d5db;">
                            Subtotal
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                            {{ $_totalTerakhir }}
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                            {{ $_totalSebelumnya }}
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                            {{ $_totalPemakaian }}
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 16px;"></td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 16px;"></td>
                    </tr>
                @endforeach
                @foreach ($total_data as $key_val => $val)
                    <tr style="background-color: yellow; transition: background-color 0.3s;">
                        <td style="border: 1px solid #d1d5db;  text-align: center;"></td>
                        <td style="border: 1px solid #d1d5db; font-size: 12px;" colspan="3" class="font-bold">
                            @if ($key_val == 'total')
                                Penjualan Air Irigasi Dari Tanggal 1 s/d Hari Ini
                            @else
                                Rata - rata Penjualan Air Irigasi Dari Tanggal 1 s/d Hari Ini
                            @endif
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 5px; text-align: right;">
                            {{ $val }}
                        </td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 16px;"></td>
                        <td style="border: 1px solid #d1d5db; padding: 8px 16px;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="header" style="margin-top: 40px;">
            <tr>
                <td style="text-align: center;">
                    <p class="uppercase">
                        pengawas
                    </p>
                    <p style="margin-top: 50px;">(..................................)</p>
                </td>
                <td style="text-align: center">
                    <p class="uppercase">
                        pelaksana
                    </p>
                    <p style="margin-top: 50px;">(..................................)</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
