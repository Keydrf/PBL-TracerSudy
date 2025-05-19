@extends('layouts_dashboard.template')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Gaya Dasar untuk Grafik */
        .chart-container {
            width: 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Gaya untuk Label di Dalam Grafik */
        .pie-chart-label {
            font-size: 1rem;
            font-weight: bold;
            color: #000;
            text-anchor: middle;
            dominant-baseline: middle;
        }

        /* Gaya untuk Garis Pemisah Slice */
        .pie-slice-path {
            stroke: #fff;
            stroke-width: 2px;
            fill: transparent;
        }

        /* Gaya untuk Grid dengan 2 Kolom */
        .row-grafik {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-6 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            flex: 0 0 50%;
            max-width: 50%;
        }

        /* Gaya untuk 4 Kolom */
        .col-md-3 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            flex: 0 0 25%;
            /* 100% / 4 = 25% */
            max-width: 25%;
        }

        /* Gaya untuk Judul yang Ditengah */
        .judul-tengah {
            text-align: center;
            font-size: 1.5rem;
            /* Ubah ukuran font sesuai kebutuhan */
            font-weight: bold;
            margin-bottom: 1rem;
            /* Tambahkan margin bawah agar tidak terlalu dekat dengan grafik */
        }
    </style>

{{-- FILTER --}}
<div class="card mb-4">
    <div class="card-header">
        <h5>Filter Data</h5>
    </div>
    <div class="card-body">
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <select name="program_studi" id="program_studi" class="form-select">
                        @php
                            $programStudiOptions = [
                                'D4 TI' => 'D4 TI',
                                'D4 SIB' => 'D4 SIB',
                                'D2 PPLS' => 'D2 PPLS',
                                'S2 MRTI' => 'S2 MRTI'
                            ];
                        @endphp
                        @foreach($programStudiOptions as $key => $val)
                            <option value="{{ $key }}" {{ request('program_studi', 'D4 TI') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun_awal" class="form-label">Tahun Awal</label>
                    <input type="number" name="tahun_awal" id="tahun_awal" class="form-control"
                           value="{{ request('tahun_awal', \Carbon\Carbon::now()->year - 3) }}" min="2000" max="{{ \Carbon\Carbon::now()->year }}">
                </div>
                <div class="col-md-3">
                    <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                    <input type="number" name="tahun_akhir" id="tahun_akhir" class="form-control"
                           value="{{ request('tahun_akhir', \Carbon\Carbon::now()->year) }}" min="2000" max="{{ \Carbon\Carbon::now()->year }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('dashboard.judul_kartu.alumni_per_prodi')</h5>

                    </div>
                    <div class="card-body">
                        <div id="prodiChartContainer" class="chart-container">
                            <canvas id="prodiPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jumlah Alumni per Kategori Profesi</h5>

                    </div>
                    <div class="card-body">
                        <div id="kategoriProfesiChartContainer" class="chart-container">
                            <canvas id="kategoriProfesiPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('dashboard.judul_kartu.jumlah_profesi_per_kategori')</h5>

                    </div>
                    <div class="card-body">
                        <div id="jumlahProfesiChartContainer" class="chart-container">
                            <canvas id="jumlahProfesiPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="row row-grafik">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('dashboard.judul_kartu.sebaran_profesi')</h5>
                        <p class="card-category">@lang('dashboard.deskripsi.sebaran_profesi')</p>
                    </div>
                    <div class="card-body">
                        <div id="sebaranProfesiChartContainer" class="chart-container">
                            <canvas id="sebaranProfesiPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('dashboard.judul_kartu.sebaran_instansi')</h5>
                        <p class="card-category">@lang('dashboard.deskripsi.sebaran_instansi')</p>
                    </div>
                    <div class="card-body">
                        <div id="jenisInstansiChartContainer" class="chart-container">
                            <canvas id="jenisInstansiPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
{{-- tabel-tabel --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Sebaran Lingkup Tempat Kerja dan Kesesuaian Profesi dengan Infokom</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm text-center" id="tableLingkupTempatKerja">
            <thead class="table-light">
                <tr>
                    <th>Lingkup Tempat Kerja</th>
                    <th>Jumlah Alumni</th>
                    <th>Kesesuaian dengan Infokom (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lingkupTempatKerjaData ?? [] as $item)
                    <tr>
                        <td>{{ $item['lingkup_tempat_kerja'] }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>{{ number_format($item['kesesuaian_infokom'], 2) }}%</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Data tidak tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Rata-rata Masa Tunggu Mendapatkan Pekerjaan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm text-center" id="tableMasaTunggu">
            <thead class="table-light">
                <tr>
                    <th>Program Studi</th>
                    <th>Rata-rata Masa Tunggu (Bulan)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masaTungguData ?? [] as $item)
                    <tr>
                        <td>{{ $item->program_studi }}</td>
                        <td>{{ number_format($item->rata_rata_bulan, 2) }}</td>

                    </tr>
                @empty
                    <tr><td colspan="2">Data tidak tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="row">
        <div class="col-md-12">
            <h5 class="card-title judul-tengah">Penilaian Kepuasan Pengguna Lulusan</h5>
            <p class="card-category text-center">Skala Penilaian</p>
        </div>
    </div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Penilaian Kepuasan Pengguna Lulusan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm text-center" id="tableKepuasanPengguna">
            <thead class="table-light">
                <tr>
                    <th>Kriteria</th>
                    <th>Nilai Rata-rata</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiKepuasan ?? [] as $kriteria => $nilai)
                    <tr>
                        <td>{{ ucwords(str_replace('_', ' ', $kriteria)) }}</td>
                        <td>{{ number_format($nilai['rata_rata'], 2) }}</td>
                        <td>{{ $nilai['keterangan'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Data tidak tersedia</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <h5 class="card-title judul-tengah">@lang('dashboard.judul_kartu.kepuasan_pengguna')</h5>
                <p class="card-category text-center">@lang('dashboard.deskripsi.kepuasan_pengguna')</p>
            </div>
        </div>
<div class="card">
    <div class="row row-grafik">
        @foreach ($kriteriaKepuasan as $kriteria)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ ucwords(str_replace('_', ' ', $kriteria)) }}</h5>
                    </div>
                    <div class="card-body">
                        <div id="kepuasan_{{ $loop->index }}" class="chart-container">
                            <canvas id="kepuasanPieChart_{{ $loop->index }}"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        window.addEventListener("DOMContentLoaded", function() {
            // Data Alumni Berdasarkan Program Studi (Dummy)
            const dataChart1 = {
                labels: ['TI', 'S', 'PPL Situs'],
                series: [1, 1, 1]
            };

            // Data Alumni Berdasarkan Kategori Profesi (Dummy)
            const dataChart2 = {
                labels: ['Bidang Infokom', 'Belum Bekerja'],
                series: [2, 1]
            };

            // Jumlah Profesi per Kategori (Dummy)
            const dataChart3 = {
                labels: ['Bidang Infokom', 'Non infokom', 'Belum Bekerja'],
                series: [7, 4, 1]
            };

            function createPieChart(canvasId, data, title) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                return new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: title,
                            data: data.series,
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                                '#FF8E72', '#64B5F6', '#81C784', '#A1887F', '#D4E157'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    fontColor: '#000',
                                    fontSize: 14,
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFontColor: '#fff',
                                bodyFontColor: '#fff',
                                borderColor: '#fff',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? (value / total * 100).toFixed(
                                            1) + '%' : '0%';
                                        label += value + ' (' + percentage + ')';
                                        return label;
                                    }
                                }
                            },
                            labels: {
                                render: 'percentage',
                                fontColor: '#000',
                                position: 'default',
                                arc: true,
                                precision: 1,
                                showActualPercentages: true
                            }
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 0,
                                bottom: 0
                            }
                        }
                    }
                });
            }

            // Buat Pie Chart Dummy
            createPieChart('prodiPieChart', dataChart1, 'Jumlah Alumni per Prodi');
            createPieChart('kategoriProfesiPieChart', dataChart2, 'Alumni per Kategori Profesi');
            createPieChart('jumlahProfesiPieChart', dataChart3, 'Jumlah Profesi per Kategori');


            // Pie Chart Sebaran Profesi Lulusan
            const dataProfesiPie = {
                labels: @json($labelsProfesi ?? []),
                series: @json($dataProfesi ?? [])
            };

            createPieChart('sebaranProfesiPieChart', dataProfesiPie, 'Sebaran Profesi Lulusan');


            // Pie Chart Sebaran Jenis Instansi
            const dataInstansiPie = {
                labels: @json($labelsInstansi ?? []),
                series: @json($dataInstansi ?? [])
            };
            createPieChart('jenisInstansiPieChart', dataInstansiPie, 'Sebaran Jenis Instansi');

            // Pie Chart Penilaian Kepuasan Pengguna Lulusan
            const dataKepuasanPengguna = @json($dataKepuasan ?? []);
            const kriteriaKepuasan = @json($kriteriaKepuasan ?? []);

            kriteriaKepuasan.forEach(function(kriteria, index) {
                const chartId = `kepuasanPieChart_${index}`;
                const data = dataKepuasanPengguna[kriteria];
                if (data && data.labels && data.series) {
                    createPieChart(chartId, data, kriteria);
                }
            });
        });
    </script>
@endsection
