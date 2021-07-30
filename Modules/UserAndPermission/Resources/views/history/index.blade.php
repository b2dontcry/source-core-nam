@extends('userandpermission::layouts.master')
@section('title', __('History management'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Histories list') }}" />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="GET" id="form-filter">
                    <div class="card">
                        <div class="card-body table-responsive pl-0 pr-0">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Title')</th>
                                        <th>@lang('Action')</th>
                                        <th>@lang('Time')</th>
                                        <th>IP</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $index => $item)
                                        <tr>
                                            <td>
                                                @php
                                                    $ipp = $_GET['perpage'] ?? 10;
                                                    $crp = $_GET['page'] ?? 1;
                                                    $order = $index + 1 + $ipp * ($crp - 1);
                                                    echo $order;
                                                @endphp
                                            </td>
                                            <td>
                                                @lang("histories.{$item->table_name}.{$item->key}.title")
                                            </td>
                                            <td>
                                                {!! sprintf(__(("histories.{$item->table_name}.{$item->key}.action")), "<b>{$item->username}</b>") !!}
                                            </td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->ip_address }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-detail" data-id="{{ $item->id }}">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center">@lang('No data found')</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            @isset($list)
                                {!! $list->appends($filter ?? null)->links('userandpermission::vendor.pagination') !!}
                            @endisset
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div id="modal-result"></div>
@endsection
@push('scripts')
    <script src="{{ asset('static/backend/js/history.js') }}"></script>
@endpush
