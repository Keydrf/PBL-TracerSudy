@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  /* Tambahkan border ke seluruh tabel dan radius sudut */
  #table-level.table-bordered {
      border-radius: 8px; /* Sesuaikan nilai radius sesuai keinginan Anda */
      overflow: hidden; /* Penting agar border-radius tidak "bocor" di dalam sel */
  }

  #table-level.table-bordered th,
  #table-level.table-bordered td {
      border: 1px solid #dee2e6;
      border-left: none; /* Hilangkan border kiri sel */
      border-right: none; /* Hilangkan border kanan sel */
  }

  /* Tambahkan border kiri dan kanan hanya pada baris pertama (header) */
  #table-level.table-bordered thead th:first-child,
  #table-level.table-bordered tbody tr:first-child td:first-child {
      border-left: 1px solid #dee2e6;
  }

  #table-level.table-bordered thead th:last-child,
  #table-level.table-bordered tbody tr:first-child td:last-child {
      border-right: 1px solid #dee2e6;
  }

  /* Tambahkan border bawah hanya pada header */
  #table-level.table-bordered thead th {
      border-bottom: 2px solid #dee2e6;
  }

  /* Style untuk header tabel */
  #table-level thead th {
      background-color: #84b5e5;
      color: white;
      white-space: nowrap;
  }

  /* Style untuk sel-sel tabel */
  #table-level td {
      vertical-align: middle;
  }

  /* Style untuk kolom nama */
  #table-level td:nth-child(4) { /* Kolom keempat (indeks 3) adalah Nama */
      font-weight: bold;
  }

  /* Efek hover pada baris */
  #table-level tbody tr:hover {
      background-color: #f0f0f0;
  }

  /* Style untuk tombol aksi */
  #table-level .btn-sm {
      margin-right: 5px;

  }
  .btn-add{
    background-color: #84b5e5;
    color: #ffffff;
  }
</style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Data Level</h4>
                    <a href="{{ url('/level/create') }}" class="btn btn-sm btn-add">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive">
                        
                        <table class="table table-bordered table-sm table-striped table-hover" id="table-level">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Level</th>
                                    <th>Nama Level</th>
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
            const tableAdmin = $('#table-level').DataTable({ // Menggunakan const dan nama variabel yang lebih deskriptif
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('level/list') }}",
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
                    { data: "level_kode", className: "" },
                    { data: "level_nama", className: "" },
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
            // $('#table-level_filter input').unbind().bind('keyup', function (e) {
            //     if (e.keyCode === 13) {
            //         tableadmin.search(this.value).draw();
            //     }
            // });
        });
    </script>
@endpush