@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('alumni.page_title')</h4>
                    <a href="{{ url('/alumni/create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i>@lang('alumni.add_button')
                    </a>
                    <button onclick="modalAction('{{ url('/alumni/import') }}')" class="btn btn-sm btn-primary"><i class="mdi mdi-file-import me-2"></i>@lang('alumni.import_button')</button>
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
                                    <th>@lang('alumni.table.headers.number')</th>
                                    <th>@lang('alumni.table.headers.study_program')</th>
                                    <th>@lang('alumni.table.headers.nim')</th>
                                    <th>@lang('alumni.table.headers.name')</th>
                                    <th>@lang('alumni.table.headers.email')</th>
                                    <th>@lang('alumni.table.headers.otp_codes')</th>
                                    <th>@lang('alumni.table.headers.graduation_date')</th>
                                    <th>@lang('alumni.table.headers.action')</th>
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
            window.tableLulusan = $('#table-lulusan').DataTable({ // Ubah ke window agar global
                processing: true,
                serverSide: true,
                language: @json(__('alumni.datatable')),
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
                    { data: "email", className: "" },
                    { data: "kode_otp_alumni", className: "" },
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