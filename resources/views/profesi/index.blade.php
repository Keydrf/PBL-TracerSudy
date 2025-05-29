@extends('layouts_dashboard.template')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('profession.title')</h4>
                <a href="{{ url('/profesi/create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>@lang('profession.button.tambah')
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

                    <table class="table table-bordered table-sm table-striped table-hover" id="table-profesi">
                        <thead>
                            <tr>
                                <th>@lang('profession.no')</th>
                                <th>@lang('profession.kategori_profesi')</th>
                                <th>@lang('profession.nama_profesi')</th>
                                <th>@lang('profession.deskripsi')</th>
                                <th>@lang('profession.aksi')</th>
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
        window.dataProfesi = $('#table-profesi').DataTable({ // Jadikan global
            processing: true,
            serverSide: true,
            language: @json(__('profession.datatable')),
            ajax: {
                url: "{{ url('profesi/list') }}", // Ganti URL ini
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }, // Tambahkan CSRF header
                data: function (d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "kategori_profesi.nama_kategori",
                    orderable: true,
                    searchable: true
                }, // Relasi ke kategori
                {
                    data: "nama_profesi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "deskripsi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        if ($('#kategori_id').length) {
            $('#kategori_id').on('change', function () {
                window.dataProfesi.ajax.reload();
            });
        }
    });
</script>
@endpush
