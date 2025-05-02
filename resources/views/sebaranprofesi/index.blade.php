@extends('layouts_lp.template')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Sebaran Profesi Alumni</h2>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sebaran Berdasarkan Kategori</h5>
                    <canvas id="sebaranKategoriChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profesi di Bidang Infokom</h5>
                    <canvas id="profesiInfokomChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profesi di Bidang Non-Infokom</h5>
                    <canvas id="profesiNonInfokomChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const pastelColors = [
        '#FAF0E6', '#FFB6C1', '#ADD8E6', '#B0C4DE', '#D3D3D3',
        '#FFE4C4', '#E6E6FA', '#F0F8FF', '#AFEEEE', '#90EE90',
        '#FFDAB9', '#FFFACD', '#F5F5DC', '#F8BBD0', '#87CEEB'
    ];

    function getColor(index) {
        return pastelColors[index % pastelColors.length];
    }

    // Data dari Laravel
    const labelsKategori = @json($labelsKategori);
    const dataKategori = @json($dataKategori);

    const labelsInfokom = @json($labelsProfesiInfokom);
    const dataInfokom = @json($dataProfesiInfokom);

    const labelsNonInfokom = @json($labelsProfesiNonInfokom);
    const dataNonInfokom = @json($dataProfesiNonInfokom);

    // Generate warna otomatis
    function generateColors(length, offset = 0) {
        const colors = [];
        for (let i = 0; i < length; i++) {
            colors.push(getColor(i + offset));
        }
        return colors;
    }

    // Chart: Sebaran Berdasarkan Kategori
    new Chart(document.getElementById('sebaranKategoriChart'), {
        type: 'bar',
        data: {
            labels: labelsKategori,
            datasets: [{
                label: 'Jumlah Alumni',
                data: dataKategori,
                backgroundColor: generateColors(dataKategori.length),
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: ${context.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Alumni' },
                    ticks: { precision: 0 }
                },
                x: {
                    title: { display: true, text: 'Kategori Profesi' }
                }
            }
        }
    });

    // Chart: Profesi Infokom
    new Chart(document.getElementById('profesiInfokomChart'), {
        type: 'bar',
        data: {
            labels: labelsInfokom,
            datasets: [{
                label: 'Jumlah Alumni',
                data: dataInfokom,
                backgroundColor: generateColors(dataInfokom.length, 3)
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: ${context.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Alumni' },
                    ticks: { precision: 0 }
                },
                x: {
                    title: { display: true, text: 'Profesi' }
                }
            }
        }
    });

    // Chart: Profesi Non-Infokom
    new Chart(document.getElementById('profesiNonInfokomChart'), {
        type: 'bar',
        data: {
            labels: labelsNonInfokom,
            datasets: [{
                label: 'Jumlah Alumni',
                data: dataNonInfokom,
                backgroundColor: generateColors(dataNonInfokom.length, 7),
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: ${context.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Alumni' },
                    ticks: { precision: 0 }
                },
                x: {
                    title: { display: true, text: 'Profesi' }
                }
            }
        }
    });
</script>
@endsection
