@extends('layouts_dashboard.template')

@section('content')
    <style>
        #chartEmail1, #chartEmail2, #chartEmail3 {
            height: 300px;
        }
    </style>

    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jumlah Alumni per Prodi</h5>
                        <p class="card-category">Last Campaign Performance</p>
                    </div>
                    <div class="card-body">
                        <div id="chartEmail1"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jumlah Alumni per Kategori Profesi</h5>
                        <p class="card-category">Last Campaign Performance</p>
                    </div>
                    <div class="card-body">
                        <div id="chartEmail2"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jumlah Profesi per Kategori</h5>
                        <p class="card-category">Last Campaign Performance</p>
                    </div>
                    <div class="card-body">
                        <div id="chartEmail3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chartist CDN --}}
    <script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

    <script>
        window.addEventListener("DOMContentLoaded", function () {
            // Data Alumni Berdasarkan Program Studi
            const dataChart1 = {
                labels: ['TI', 'S', 'PPL Situs'],
                series: [1, 1, 1]
            };
    
            // Data Alumni Berdasarkan Kategori Profesi
            const dataChart2 = {
                labels: ['Bidang Infokom', 'Belum Bekerja'],
                series: [2, 1]
            };
    
            // Jumlah Profesi per Kategori
            const dataChart3 = {
                labels: ['Bidang Infokom', 'Non infokom', 'Belum Bekerja'],
                series: [7,4,1]
            };
    
            function withPercentage(data) {
                const total = data.series.reduce((a, b) => a + b, 0);
                return {
                    ...data,
                    labels: data.labels.map((label, index) => {
                        const percent = ((data.series[index] / total) * 100).toFixed(1);
                        return `${label} (${percent}%)`;
                    })
                };
            }
    
            const options = {
                labelInterpolationFnc: function (value) {
                    return value;
                }
            };
    
            new Chartist.Pie('#chartEmail1', withPercentage(dataChart1), options);
            new Chartist.Pie('#chartEmail2', withPercentage(dataChart2), options);
            new Chartist.Pie('#chartEmail3', withPercentage(dataChart3), options);
        });
    </script>
    
@endsection
