@extends('layouts_lp.template')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Sebaran Profesi</h2>
            {{-- <p>Berikut merupakan visualisasi sebaran profesi alumni dalam bentuk diagram.</p> --}}
        </div>

        <div class="col-lg-12">
            <canvas id="sebaranProfesiChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('sebaranProfesiChart').getContext('2d');
        const sebaranProfesiChart = new Chart(ctx, {
            type: 'bar', // Bisa diubah ke 'pie', 'doughnut', dll
            data: {
                labels: ['PNS', 'Wirausaha', 'Swasta', 'BUMN', 'Freelancer'],
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: [45, 25, 80, 30, 20],
                    backgroundColor: [
                        '#1e90ff',
                        '#ff7f50',
                        '#28a745',
                        '#ffc107',
                        '#6f42c1'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Alumni'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Profesi'
                        }
                    }
                }
            }
        });
    </script>
@endsection
