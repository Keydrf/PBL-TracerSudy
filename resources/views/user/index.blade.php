@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('user.page_title')</h4>
                    <a href="{{ url('/user/create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i>@lang('user.button.tambah')
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
                        
                        <table class="table table-bordered table-sm table-striped table-hover" id="table-admin">
                            <thead>
                                <tr>
                                    <th>@lang('user.table.headers.number')</th>
                                    <th>@lang('user.table.headers.level')</th>
                                    <th>@lang('user.table.headers.username')</th>
                                    <th>@lang('user.table.headers.name')</th>
                                    <th>@lang('user.table.headers.action')</th>
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

        var dataUser;
        $(document).ready(function () {
            dataUser = $('#table-admin').DataTable({
                processing: true,
                serverSide: true,
                language: @json(__('user.datatable')),
                ajax: {
                    url: "{{ url('user/list') }}",
                    type: "POST",
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }, // Tambahkan CSRF header
                    data: function (d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "username", orderable: true, searchable: true },
                    { data: "nama", orderable: true, searchable: true },
                    { data: "level.level_nama", orderable: true, searchable: false },
                    { data: "aksi", orderable: false, searchable: false }
                ]
            });

            if ($('#level_id').length) {
                $('#level_id').on('change', function () {
                    dataUser.ajax.reload();
                });
            }
        });     
    </script>
@endpush