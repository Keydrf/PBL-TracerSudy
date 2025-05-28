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
        <h5>@lang('dashboard.judul_kartu.filter_data')</h5>
    </div>
    <div class="card-body">
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="program_studi" class="form-label">@lang('dashboard.label_chart.prodi')</label>
                    <select name="program_studi" id="program_studi" class="form-select">
                        @php
                            $programStudiOptions = [
                                'Semuanya' =>'Semuanya',
                                'Teknik Informatika' => 'Teknik Informatika',
                                'Sistem Informasi bisnis' => 'Sistem Informasi bisnis',
                                'Pengembangan Perangkat Lunak Situs' => 'Pengembangan Perangkat Lunak Situs',
                                'Magister Terapan Rekayasa Teknologi Informasi' => 'Magister Terapan Rekayasa Teknologi Informasi'
                            ];
                        @endphp
                        @foreach($programStudiOptions as $key => $val)
                            <option value="{{ $key }}" {{ request('program_studi', 'Teknik Informatika') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun_awal" class="form-label">@lang('dashboard.label_chart.tahun_awal')</label>
                    <input type="number" name="tahun_awal" id="tahun_awal" class="form-control"
                           value="{{ request('tahun_awal', \Carbon\Carbon::now()->year - 3) }}" min="2000" max="{{ \Carbon\Carbon::now()->year }}">
                </div>
                <div class="col-md-3">
                    <label for="tahun_akhir" class="form-label">@lang('dashboard.label_chart.tahun_akhir')</label>
                    <input type="number" name="tahun_akhir" id="tahun_akhir" class="form-control"
                           value="{{ request('tahun_akhir', \Carbon\Carbon::now()->year) }}" min="2000" max="{{ \Carbon\Carbon::now()->year }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">@lang('dashboard.tombol.filter')</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
<div class="card mb-4">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center py-2" style="background-color: #f0f0f0;">
                   <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                        @lang("dashboard.judul_kartu.alumni_per_prodi")
                    </h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="prodiChartContainer" class="chart-container" style="width: 100%; height: 200px;">
                        <canvas id="prodiPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center py-2" style="background-color: #f0f0f0;">
                    <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                        @lang('dashboard.judul_kartu.alumni_per_kategori_profesi')
                    </h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="kategoriProfesiChartContainer" class="chart-container" style="width: 100%; height: 200px;">
                        <canvas id="kategoriProfesiPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header text-center py-2" style="background-color: #f0f0f0;">
                    <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                        @lang('dashboard.judul_kartu.jumlah_profesi_per_kategori')
                    </h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="jumlahProfesiChartContainer" class="chart-container" style="width: 100%; height: 200px;">
                        <canvas id="jumlahProfesiPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header py-2 text-center" style="background-color: #f0f0f0;">
                    <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                        @lang('dashboard.judul_kartu.sebaran_profesi')
                    </h6>
                    <p class="card-category text-muted mb-0" style="font-size: 13px;">
                        @lang('dashboard.deskripsi.sebaran_profesi')
                    </p>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="sebaranProfesiChartContainer" class="chart-container" style="width: 100%; height: 200px;">
                        <canvas id="sebaranProfesiPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header py-2 text-center" style="background-color: #f0f0f0;">
                    <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                        @lang('dashboard.judul_kartu.sebaran_instansi')
                    </h6>
                    <p class="card-category text-muted mb-0" style="font-size: 13px;">
                        @lang('dashboard.deskripsi.sebaran_instansi')
                    </p>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="jenisInstansiChartContainer" class="chart-container" style="width: 100%; height: 200px;">
                        <canvas id="jenisInstansiPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- tabel-tabel --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">@lang('dashboard.judul_kartu.sebaran_lingkup_tempat_kerja')</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm text-center" id="tableLingkupTempatKerja">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2">@lang('dashboard.tabel_header.tahun_lulus')</th>
                        <th rowspan="2">@lang('dashboard.tabel_header.jumlah_lulusan')</th>
                        <th rowspan="2">@lang('dashboard.tabel_header.lulusan_terlacak')</th>
                        <th rowspan="2">@lang('dashboard.tabel_header.profesi_infokom')</th>
                        <th rowspan="2">@lang('dashboard.tabel_header.profesi_non_infokom')</th>
                        <th colspan="4">@lang('dashboard.tabel_header.lingkup_tempat_kerja')</th>
                    </tr>
                    <tr>
                        <th>@lang('dashboard.tabel_header.lingkup_tempat_kerja_detail.multinasional')</th>
                        <th>@lang('dashboard.tabel_header.lingkup_tempat_kerja_detail.nasional')</th>
                        <th>@lang('dashboard.tabel_header.lingkup_tempat_kerja_detail.wirausaha')</th>
                        <th>@lang('dashboard.tabel_header.lingkup_tempat_kerja_detail.lokal')</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = [
                            'jumlah_alumni' => 0,
                            'jumlah_terlacak' => 0,
                            'profesi_infokom' => 0,
                            'profesi_non_infokom' => 0,
                            'multinasional' => 0,
                            'nasional' => 0,
                            'wirausaha' => 0,
                            'lokal' => 0
                        ];
                    @endphp

                    @forelse($lingkupTempatKerjaData ?? [] as $item)
                        <tr>
                            <td>{{ $item->tahun_lulus }}</td>
                            <td>{{ $item->jumlah_alumni }}</td>
                            <td>{{ $item->jumlah_terlacak }}</td>
                            <td>{{ $item->profesi_infokom }}</td>
                            <td>{{ $item->profesi_non_infokom }}</td>
                            <td>{{ $item->multinasional }}</td>
                            <td>{{ $item->nasional }}</td>
                            <td>{{ $item->wirausaha }}</td>
                            <td>{{ $item->lokal }}</td>
                        </tr>

                        @php
                            $total['jumlah_alumni'] += $item->jumlah_alumni;
                            $total['jumlah_terlacak'] += $item->jumlah_terlacak;
                            $total['profesi_infokom'] += $item->profesi_infokom;
                            $total['profesi_non_infokom'] += $item->profesi_non_infokom;
                            $total['multinasional'] += $item->multinasional;
                            $total['nasional'] += $item->nasional;
                            $total['wirausaha'] += $item->wirausaha;
                            $total['lokal'] += $item->lokal;
                        @endphp
                    @empty
                        <tr><td colspan="9">@lang('dashboard.pesan.data_tidak_tersedia')</td></tr>
                    @endforelse
                </tbody>
                <tfoot style="background-color: #848484; font-weight: bold;">
                    <tr>
                        <td>@lang('dashboard.label_chart.jumlah')</td>
                        <td>{{ $total['jumlah_alumni'] }}</td>
                        <td>{{ $total['jumlah_terlacak'] }}</td>
                        <td>{{ $total['profesi_infokom'] }}</td>
                        <td>{{ $total['profesi_non_infokom'] }}</td>
                        <td>{{ $total['multinasional'] }}</td>
                        <td>{{ $total['nasional'] }}</td>
                        <td>{{ $total['wirausaha'] }}</td>
                        <td>{{ $total['lokal'] }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">@lang('dashboard.judul_kartu.rata_masa_tunggu')</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm text-center" id="tableMasaTunggu">
            <thead class="table-light">
                <tr>
                    <th>@lang('dashboard.tabel_header.tahun_lulus')</th>
                    <th>@lang('dashboard.tabel_header.jumlah_lulusan')</th>
                    <th>@lang('dashboard.tabel_header.lulusan_terlacak')</th>
                    <th>@lang('dashboard.tabel_header.rata_masa_tunggu')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masaTungguData ?? [] as $item)
                    <tr>
                    <td>{{ $item->tahun_lulus }}</td>
                    <td>{{ $item->jumlah_alumni }}</td>
                    <td>{{ $item->jumlah_terlacak }}</td>
                    <td>{{ number_format($item->rata_rata_bulan, 2) }}</td>
                </tr>
                @empty
                    <tr><td colspan="4">@lang('dashboard.pesan.data_tidak_tersedia')</td></tr>
                @endforelse
            </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td>@lang('dashboard.label_chart.jumlah')</td>
                        <td>{{ $totalMasaTunggu['jumlah_alumni'] }}</td>
                        <td>{{ $totalMasaTunggu['jumlah_terlacak'] }}</td>
                        <td>{{ number_format($totalMasaTunggu['rata_rata_bulan'], 2) }}</td>
                    </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0 text-center">@lang('dashboard.judul_kartu.penilaian_kepuasan_pengguna')</h5>
        <p class="card-category text-center mb-0">@lang('dashboard.deskripsi.skala_penilaian')</p>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm text-center" id="tableKepuasanPengguna">
            <thead class="table-light">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">@lang('dashboard.tabel_header.jenis_kemampuan')</th>
                    <th colspan="4">@lang('dashboard.tabel_header.tingkat_kepuasan_pengguna')</th>
                </tr>
                <tr>
                    <th>@lang('dashboard.tabel_header.skala_nilai.sangat_baik')</th>
                    <th>@lang('dashboard.tabel_header.skala_nilai.baik')</th>
                    <th>@lang('dashboard.tabel_header.skala_nilai.cukup')</th>
                    <th>@lang('dashboard.tabel_header.skala_nilai.kurang')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiKepuasan ?? [] as $kriteria => $nilai)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>@lang("dashboard.kriteria_kepuasan.$kriteria")</td>
                        <td>{{ number_format($nilai['sangat_baik'] ?? 0, 2) }}%</td>
                        <td>{{ number_format($nilai['baik'] ?? 0, 2) }}%</td>
                        <td>{{ number_format($nilai['cukup'] ?? 0, 2) }}%</td>
                        <td>{{ number_format($nilai['kurang'] ?? 0, 2) }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">@lang('dashboard.pesan.data_tidak_tersedia')</td>
                    </tr>
                @endforelse

                @if (!empty($nilaiKepuasan))
                    @php
                        $totalKriteria = count($nilaiKepuasan);
                        $totalSangatBaik = $totalBaik = $totalCukup = $totalKurang = 0;

                        foreach ($nilaiKepuasan as $nilai) {
                            $totalSangatBaik += $nilai['sangat_baik'];
                            $totalBaik       += $nilai['baik'];
                            $totalCukup      += $nilai['cukup'];
                            $totalKurang     += $nilai['kurang'];
                        }

                        $avgSangatBaik = $totalSangatBaik / $totalKriteria;
                        $avgBaik       = $totalBaik / $totalKriteria;
                        $avgCukup      = $totalCukup / $totalKriteria;
                        $avgKurang     = $totalKurang / $totalKriteria;
                    @endphp
                    <tr style="background-color: #d3d3d3; font-weight: bold;">
                        <td colspan="2">@lang('dashboard.label_chart.jumlah')</td>
                        <td>{{ number_format($avgSangatBaik, 2) }}%</td>
                        <td>{{ number_format($avgBaik, 2) }}%</td>
                        <td>{{ number_format($avgCukup, 2) }}%</td>
                        <td>{{ number_format($avgKurang, 2) }}%</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="row">
        <div class="col-md-12 text-center p-3">
            <h5 class="card-title mb-1" style="font-weight: 600;">
                @lang('dashboard.judul_kartu.kepuasan_pengguna')
            </h5>
            <p class="card-category text-muted mb-0" style="font-size: 14px;">
                @lang('dashboard.deskripsi.kepuasan_pengguna')
            </p>
        </div>
    </div>

    <div class="card-body">
        <div class="row row-grafik">
            @foreach ($kriteriaKepuasan as $kriteria)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header text-center py-2" style="background-color: #f0f0f0;">
                            <h6 class="mb-0" style="font-weight: 600; font-size: 15px;">
                                @lang("dashboard.kriteria_kepuasan.$kriteria")
                            </h6>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <div id="kepuasan_{{ $loop->index }}" class="chart-container" style="width: 100%; height: 200px;">
                                <canvas id="kepuasanPieChart_{{ $loop->index }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        window.addEventListener("DOMContentLoaded", function() {
            // Data Alumni Berdasarkan Program Studi (Dummy)
            const dataChart1 = {
                labels: ['Teknik Informatika', 'Sistem Informasi Bisnis', 'Pengembangan Piranti Lunak Situs'],
                series: [1, 1, 1]
            };

            // Data Alumni Berdasarkan Kategori Profesi (Dummy)
            const dataChart2 = {
                labels: ['Bidang Infokom', 'Non infokom'],
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


            // Pie Chart Sebaran Profesi alumni
            const dataProfesiPie = {
                labels: @json($labelsProfesi ?? []),
                series: @json($dataProfesi ?? [])
            };

            createPieChart('sebaranProfesiPieChart', dataProfesiPie, 'Sebaran Profesi Alumni');


            // Pie Chart Sebaran Jenis Instansi
            const dataInstansiPie = {
                labels: @json($labelsInstansi ?? []),
                series: @json($dataInstansi ?? [])
            };
            createPieChart('jenisInstansiPieChart', dataInstansiPie, 'Sebaran Jenis Instansi');

            // Pie Chart Penilaian Kepuasan Pengguna Alumni
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
