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
                        <h5 class="card-title">@lang('dashboard.judul_kartu.alumni_per_kategori_profesi')</h5>

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
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <h5 class="card-title judul-tengah">@lang('dashboard.judul_kartu.kepuasan_pengguna')</h5>
                <p class="card-category text-center">@lang('dashboard.deskripsi.kepuasan_pengguna')</p>
            </div>
        </div>
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
