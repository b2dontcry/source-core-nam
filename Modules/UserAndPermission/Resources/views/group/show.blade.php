@extends('userandpermission::layouts.master')
@section('title', __('Group detail'))
@section('content')
@php
    $parentPage = [['text' => __('Groups list'), 'route' => 'userandpermission.group.index']];
@endphp
<x-userandpermission-headerpage current-page="{{ __('Group detail') }}" :parent-page="$parentPage" />
@isset ($detail)
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{ route('userandpermission.group.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-2"></i>@lang('Back')
                            </a>
                            @if (Gate::check('check_user_permission', ['create_group']))
                                <a href="{{ route('userandpermission.group.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>@lang('Create group')
                                </a>
                            @endif
                            @if (Gate::check('check_user_permission', ['delete_group']) && is_null($detail->deleted_at))
                                <button class="btn btn-danger btn-remove" data-id="{{ $detail->id }}">
                                    <i class="fas fa-times mr-2"></i>@lang('Delete')
                                </button>
                            @endif
                            @if (Gate::check('check_user_permission', ['edit_group']))
                                <a href="{{ route('userandpermission.group.edit', ['id' => $detail->id]) }}" class="btn btn-info">
                                    <i class="fas fa-edit mr-2"></i>@lang('Edit')
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Name')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Description')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->description }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Created by')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->created_by_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Updated by')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->updated_by_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Created at')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ date('d/m/Y H:i:s', strtotime($detail->created_at)) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Updated at')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ date('d/m/Y H:i:s', strtotime($detail->updated_at)) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            @include('userandpermission::group.partials.tabs')
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('userandpermission.group.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>@lang('Back')
                        </a>
                        @if (Gate::check('check_user_permission', ['edit_group']))
                            <a href="{{ route('userandpermission.group.edit', ['id' => $detail->id]) }}" class="btn btn-info">
                                <i class="fa fa-edit mr-2"></i>@lang('Edit')
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset
@endsection
