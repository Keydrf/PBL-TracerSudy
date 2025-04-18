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
                        <h5 class="card-title">Email Statistics 1</h5>
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
                        <h5 class="card-title">Email Statistics 2</h5>
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
                        <h5 class="card-title">Email Statistics 3</h5>
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
            const dataEmail = {
                labels: ['Open', 'Click', 'Unsubscribe'],
                series: [20, 40, 40]
            };

            const options = {
                labelInterpolationFnc: function (value) {
                    return value;
                }
            };

            new Chartist.Pie('#chartEmail1', dataEmail, options);
            new Chartist.Pie('#chartEmail2', dataEmail, options);
            new Chartist.Pie('#chartEmail3', dataEmail, options);
        });
    </script>
@endsection
