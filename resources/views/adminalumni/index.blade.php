@extends('layouts_dashboard.template')

@section('content')
<style>
  /* Tambahkan border ke seluruh tabel dan radius sudut */
  #table-lulusan.table-bordered {
      border-radius: 8px; /* Sesuaikan nilai radius sesuai keinginan Anda */
      overflow: hidden; /* Penting agar border-radius tidak "bocor" di dalam sel */
  }

  #table-lulusan.table-bordered th,
  #table-lulusan.table-bordered td {
      border: 1px solid #dee2e6;
      border-left: none; /* Hilangkan border kiri sel */
      border-right: none; /* Hilangkan border kanan sel */
  }

  /* Tambahkan border kiri dan kanan hanya pada baris pertama (header) */
  #table-lulusan.table-bordered thead th:first-child,
  #table-lulusan.table-bordered tbody tr:first-child td:first-child {
      border-left: 1px solid #dee2e6;
  }

  #table-lulusan.table-bordered thead th:last-child,
  #table-lulusan.table-bordered tbody tr:first-child td:last-child {
      border-right: 1px solid #dee2e6;
  }

  /* Tambahkan border bawah hanya pada header */
  #table-lulusan.table-bordered thead th {
      border-bottom: 2px solid #dee2e6;
  }

  /* Style untuk header tabel */
  #table-lulusan thead th {
      background-color: #84b5e5;
      color: white;
      white-space: nowrap;
  }

  /* Style untuk sel-sel tabel */
  #table-lulusan td {
      vertical-align: middle;
  }

  /* Style untuk kolom nama */
  #table-lulusan td:nth-child(4) { /* Kolom keempat (indeks 3) adalah Nama */
      font-weight: bold;
  }

  /* Efek hover pada baris */
  #table-lulusan tbody tr:hover {
      background-color: #f0f0f0;
  }

  /* Style untuk tombol aksi */
  #table-lulusan .btn-sm {
      margin-right: 5px;
  }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Data Lulusan</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped table-hover" id="table-lulusan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Studi</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lulus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            const tableLulusan = $('#table-lulusan').DataTable({ // Menggunakan const dan nama variabel yang lebih deskriptif
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('alumni/list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                },
                columns: [
                    {
                        data: null,
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: "program_studi", className: "" },
                    { data: "nim", className: "" },
                    { data: "nama", className: "" },
                    { data: "tanggal_lulus", className: "" },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        width: "25%" // Sesuaikan lebar kolom aksi jika perlu
                    }
                ]
            });

            // Anda bisa menambahkan filter jika diperlukan, contoh:
            // $('#table-lulusan_filter input').unbind().bind('keyup', function (e) {
            //     if (e.keyCode === 13) {
            //         tableLulusan.search(this.value).draw();
            //     }
            // });
        });
    </script>
@endpush