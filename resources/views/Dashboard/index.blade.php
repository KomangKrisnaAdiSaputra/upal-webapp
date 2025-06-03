@extends('layouts.main')
@section('title', 'Dashboard')

@section('data')
    <div class="container my-4">
        <div class="text-center mb-5">
            <h1 class="fw-bold">🏠 Home</h1>
            <p class="lead">Selamat datang dan selamat menggunakan <strong>SI Upal</strong></p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h4 mb-4">📊 Grafik Air Limbah dan Irigasi</h2>

                <div class="row align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="yearSelect" class="form-label fw-semibold">Pilih Tahun:</label>
                    </div>
                    <div class="col-md-4">
                        <select id="yearSelect" class="form-select">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $loop->last ? 'selected' : '' }}>{{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <canvas id="waterChart" height="100"></canvas>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('waterChart').getContext('2d');
        const bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        let chart;

        async function fetchChartData(year) {
            const baseUrl = "{{ route('dashboard.chart.data', ['tahun' => '__REPLACE__']) }}";
            const url = baseUrl.replace('__REPLACE__', year);

            const res = await fetch(url);
            const data = await res.json();
            return data;
        }

        async function updateChart(year) {
            const data = await fetchChartData(year);

            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bulan,
                    datasets: [{
                            label: 'Air Limbah',
                            data: data.limbah,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)'
                        },
                        {
                            label: 'Air Irigasi',
                            data: data.irigasi,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total'
                            }
                        }
                    }
                }
            });
        }

        // Inisialisasi grafik awal
        const initialYear = document.getElementById('yearSelect').value;
        updateChart(initialYear);

        // Ubah grafik saat dropdown berubah
        document.getElementById('yearSelect').addEventListener('change', function() {
            updateChart(this.value);
        });
    </script>
@endsection
