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
                <td style="width: 40%;">
                    <img style="max-width: 70%; height: auto%; display: inline-block;" src="{{ GlobalEnum::LOGO }}"
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
