@extends('layouts_dashboard.template')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('company.page_title')</h4>
                <a href="{{ url('/populate') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>@lang('company.add_button')
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
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-perusahaan">
                        <thead>
                            <tr>
                                <th>@lang('company.table.headers.number')</th>
                                <th>@lang('company.table.headers.supervisor_name')</th>
                                <th>@lang('company.table.headers.agency_type')</th>
                                <th>@lang('company.table.headers.agency_name')</th>
                                <th>@lang('company.table.headers.phone')</th>
                                <th>@lang('company.table.headers.email')</th>
                                <th>@lang('company.table.headers.alumni_name')</th>
                                <th>@lang('company.table.headers.program_study')</th>
                                <th>@lang('company.table.headers.graduation_year')</th>
                                <th>@lang('company.table.headers.action')</th>
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
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
    data-width="75%"></div>

@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function () {
        $('#table-perusahaan').DataTable({
            language: @json(__('company.datatable')),
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('perusahaan/list') }}",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                error: function (xhr, error, thrown) {
                    console.error('Error fetching data:', error, thrown);
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "nama_atasan", name: "nama_atasan" },
                { data: "instansi", name: "instansi" },
                { data: "nama_instansi", name: "nama_instansi" },
                { data: "no_telepon", name: "no_telepon" },
                { data: "email", name: "email" },
                { data: "nama_alumni", name: "nama_alumni" },
                { data: "program_studi", name: "program_studi" },
                { data: "tahun_lulus", name: "tahun_lulus" },
                { data: "aksi", orderable: false, searchable: false }
            ],
            order: [[1, 'asc']], // Default sorting (opsional)
            responsive: true
        });
    });
</script>
@endpush
