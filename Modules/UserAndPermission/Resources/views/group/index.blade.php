@extends('userandpermission::layouts.master')
@section('title', __('Group permissions management'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Groups list') }}" />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="GET" id="form-filter">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button type="button" class="btn btn-secondary pn-sort">
                                    <i class="fas fa-search mr-2"></i>@lang('Search')
                                </button>
                                <a href="{{ route('userandpermission.group.index') }}" class="btn btn-default">
                                    <i class="fas fa-redo mr-2"></i>@lang('Refresh')
                                </a>
                            </div>
                            <div class="card-tools">
                                @if (Gate::check('check_user_permission', ['create_group']))
                                    <a href="{{ route('userandpermission.group.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>@lang('Create group')
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body table-responsive pl-0 pr-0">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>
                                            <span class="pn-sort" data-fields="name"
                                            data-order="{{ (isset($filter['sort_name']) && $filter['sort_name'] == 'asc' ? 'desc' : 'asc') }}">
                                                @lang('Name') {!! isset($filter['sort_name'])
                                                ? ($filter['sort_name'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
                                                : '' !!}
                                            </span>
                                        </th>
                                        <th>@lang('Description')</th>
                                        <th>
                                            <span class="pn-sort" data-fields="created_at"
                                            data-order="{{ (isset($filter['sort_created_at']) && $filter['sort_created_at'] == 'asc' ? 'desc' : 'asc') }}">
                                                @lang('Created at') {!! isset($filter['sort_created_at'])
                                                ? ($filter['sort_created_at'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
                                                : '' !!}
                                            </span>
                                        </th>
                                        <th>
                                            <span class="pn-sort" data-fields="updated_at"
                                            data-order="{{ (isset($filter['sort_updated_at']) && $filter['sort_updated_at'] == 'asc' ? 'desc' : 'asc') }}">
                                                @lang('Updated at') {!! isset($filter['sort_updated_at'])
                                                ? ($filter['sort_updated_at'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
                                                : '' !!}
                                            </span>
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="search" name="name" class="form-control"
                                            placeholder="{{ __('Name') }}" value="{{ $filter['name'] ?? null }}">
                                        </td>
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $index + $list->firstItem() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('userandpermission.group.show', ['id' => $item->id]) }}">
                                                    {{ $item->name }}{{ $item->deleted_at ? ' ('.__('is deleted').')' : '' }}
                                                </a>
                                            </td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($item->updated_at)) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item text-info" href="{{ route('userandpermission.group.show', ['id' => $item->id]) }}">
                                                            <i class="far fa-eye mr-2"></i>@lang('Detail')
                                                        </a>
                                                        @if (Gate::check('check_user_permission', ['edit_group']))
                                                            <a class="dropdown-item text-primary" href="{{ route('userandpermission.group.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit mr-2"></i>@lang('Edit')
                                                            </a>
                                                        @endif
                                                        @if (Gate::check('check_user_permission', ['delete_group']))
                                                            <a class="dropdown-item btn-remove text-danger" href="javascript:void(0)" data-id="{{ $item->id }}">
                                                                <i class="far fa-trash-alt mr-2"></i>@lang('Delete')
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
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
@endsection
@push('scripts')
<script src="{{ asset('static/backend/js/group.js') }}"></script>
@endpush
