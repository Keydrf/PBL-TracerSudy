@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('professionCategory.page_title')</h4>
                    <a href="{{ url('/kategori/create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i>@lang('professionCategory.button.tambah')
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

                        <table class="table table-bordered table-sm table-striped table-hover" id="table-kategori">
                            <thead>
                                <tr>
                                    <th>@lang('professionCategory.table.headers.number')</th>
                                    <th>@lang('professionCategory.table.headers.code')</th>
                                    <th>@lang('professionCategory.table.headers.name')</th>
                                    <th>@lang('professionCategory.table.headers.action')</th>
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
            window.tableKategoriProfesi = $('#table-kategori').DataTable({ // Jadikan global
                processing: true,
                serverSide: true,
                language: @json(__('professionCategory.datatable')),
                ajax: {
                    url: "{{ url('kategori/list') }}",
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
                    { data: "kode_kategori", className: "" },
                    { data: "nama_kategori", className: "" },
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
            // $('#table-k_filter input').unbind().bind('keyup', function (e) {
            //     if (e.keyCode === 13) {
            //         tableKategoriProfesi.search(this.value).draw();
            //     }
            // });
        });
    </script>
@endpush