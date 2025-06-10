@extends('layouts_dashboard.template')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('laporan.page_title')</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ url('/laporan') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="small">@lang("laporan.table.filter.start_date")</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="small">@lang("laporan.table.filter.end_date")</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    @lang("laporan.table.filter.apply")
                                </button>
                            </div>
                        </div>
                    </form>
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
                                    <th>@lang('laporan.table.headers.number')</th>
                                    <th>@lang('laporan.table.headers.title')</th>
                                    <th>@lang('laporan.table.headers.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $filterParams = [
                                        'start_date' => request('start_date'),
                                        'end_date' => request('end_date'),
                                    ];
                                @endphp
                                @foreach ($reports as $report)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $report['title'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ url($report['url']) }}?{{ http_build_query($filterParams) }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-download me-1"></i>@lang('laporan.table.download')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
