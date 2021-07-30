@extends('userandpermission::layouts.master')
@section('title', __('User management'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Users list') }}" />
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
                                <a href="{{ route('userandpermission.user.index') }}" class="btn btn-default">
                                    <i class="fas fa-redo mr-2"></i>@lang('Refresh')
                                </a>
                            </div>
                            <div class="card-tools">
                                @if (Gate::check('check_user_permission', ['create_user']))
                                    <a href="{{ route('userandpermission.user.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>@lang('Create user')
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
                                                @lang('Full name') {!! isset($filter['sort_name'])
                                                ? ($filter['sort_name'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
                                                : '' !!}
                                            </span>
                                        </th>
                                        <th>
                                            <span class="pn-sort" data-fields="email"
                                            data-order="{{ (isset($filter['sort_email']) && $filter['sort_email'] == 'asc' ? 'desc' : 'asc') }}">
                                                @lang('Email') {!! isset($filter['sort_email'])
                                                ? ($filter['sort_email'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
                                                : '' !!}
                                            </span>
                                        </th>
                                        <th>@lang('Actived')</th>
                                        <th>
                                            <span class="pn-sort" data-fields="latest_login"
                                            data-order="{{ (isset($filter['sort_latest_login']) && $filter['sort_latest_login'] == 'asc' ? 'desc' : 'asc') }}">
                                                @lang('Latest login') {!! isset($filter['sort_latest_login'])
                                                ? ($filter['sort_latest_login'] == 'asc' ? '<i class="fas fa-sort-amount-up"></i>' : '<i class="fas fa-sort-amount-down"></i>')
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
                                        @if (auth()->user()->is_admin)
                                            <th>@lang('Deleted at')</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="search" name="name" class="form-control"
                                            placeholder="{{ __('Full name') }}" value="{{ $filter['name'] ?? null }}">
                                        </td>
                                        <td>
                                            <input type="search" name="email" class="form-control"
                                            placeholder="{{ __('Email') }}" value="{{ $filter['email'] ?? null }}">
                                        </td>
                                        <td>
                                            <select name="is_active" class="form-control">
                                                @foreach ($list_status as $value => $text)
                                                    <option value="{{ $value }}"
                                                    {{ isset($filter['is_active']) && $filter['is_active'] == $value ? 'selected' : '' }}>
                                                        @lang($text)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @if (auth()->user()->is_admin)
                                            <td colspan="4"></td>
                                        @else
                                            <td colspan="3"></td>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $index + $list->firstItem() }}
                                            </td>
                                            <td>
                                                <a href="{{ route('userandpermission.user.show', ['id' => $item->id]) }}">
                                                    {{ $item->name }}{!! $item->deleted_at
                                                        ? ' <span class="text-danger">('.__('Is deleted').')</span>'
                                                        : '' !!}
                                                </a>
                                            </td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if (Gate::check('check_user_permission', ['edit_user']))
                                                    <input type="checkbox" class="active-item" data-size="small"
                                                    data-bootstrap-switch data-off-color="danger" data-on-color="success" data-id={{ $item->id }}
                                                    {{ $item->is_active ? 'checked' : '' }}>
                                                @else
                                                    {!! $item->is_active
                                                        ? '<i class="fas fa-check text-success"></i>'
                                                        : '<i class="fas fa-times text-danger"></i>' !!}
                                                @endif
                                            </td>
                                            <td>{{ $item->latest_login }}</td>
                                            <td>{{ $item->updated_at != null ? date('d/m/Y H:i:s', strtotime($item->updated_at)) : '' }}</td>
                                            @if (auth()->user()->is_admin)
                                                <td>{{ $item->deleted_at != null ? date('d/m/Y H:i:s', strtotime($item->deleted_at)) : '' }}</td>
                                            @endif
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item text-info" href="{{ route('userandpermission.user.show', ['id' => $item->id]) }}">
                                                            <i class="far fa-eye mr-2"></i>@lang('Detail')
                                                        </a>
                                                        @if (Gate::check('check_user_permission', ['edit_user']))
                                                            <a class="dropdown-item text-primary" href="{{ route('userandpermission.user.edit', ['id' => $item->id]) }}">
                                                                <i class="fas fa-edit mr-2"></i>@lang('Edit')
                                                            </a>
                                                        @endif
                                                        @if (Gate::check('check_user_permission', ['delete_user']) && is_null($item->deleted_at))
                                                            <a class="dropdown-item btn-remove text-danger" href="javascript:void(0)" data-id="{{ $item->id }}">
                                                                <i class="far fa-trash-alt mr-2"></i>@lang('Delete')
                                                            </a>
                                                        @endif
                                                        @if (auth()->user()->is_admin && ! is_null($item->deleted_at))
                                                            <a class="dropdown-item btn-restore text-success" href="javascript:void(0)" data-id="{{ $item->id }}">
                                                                <i class="fas fa-trash-restore mr-2"></i>@lang('Restore')
                                                            </a>
                                                            <a class="dropdown-item btn-destroy text-danger" href="javascript:void(0)" data-id="{{ $item->id }}">
                                                                <i class="fas fa-times mr-2"></i>@lang('Destroy')
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{auth()->user()->is_admin ? 8 : 7}}" class="text-center">@lang('No data found')</td></tr>
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
<script src="{{ asset('static/backend/js/user.js') }}"></script>
@endpush
