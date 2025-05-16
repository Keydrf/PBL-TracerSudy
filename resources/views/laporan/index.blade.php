@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan Tracer Study & Survei Kepuasan</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Rekap Hasil Tracer Study Lulusan</td>
                                <td class="text-center">
                                    <a href="{{ url('/laporan/tracer-study') }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-download me-1"></i>Unduh
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Rekap Hasil Survei Kepuasan Pengguna Lulusan</td>
                                <td class="text-center">
                                    <a href="{{ url('/laporan/survei-kepuasan') }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-download me-1"></i>Unduh
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Daftar Lulusan yang Belum Mengisi Tracer Study</td>
                                <td class="text-center">
                                    <a href="{{ url('/laporan/belum-tracer') }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-download me-1"></i>Unduh
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Daftar Pengguna Lulusan yang Belum Mengisi Survei Kepuasan</td>
                                <td class="text-center">
                                    <a href="{{ url('/laporan/belum-survei') }}" class="btn btn-success btn-sm">
                                        <i class="fa fa-download me-1"></i>Unduh
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection