@extends('userandpermission::layouts.master')
@section('title', __('User detail'))
@section('content')
@php
    $parentPage = [['text' => __('Users list'), 'route' => 'userandpermission.user.index']];
@endphp
<x-userandpermission-headerpage current-page="{{ __('User detail') }}" :parent-page="$parentPage" />
@isset ($detail)
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <a href="{{ route('userandpermission.user.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-2"></i>@lang('Back')
                            </a>
                            @if (Gate::check('check_user_permission', ['create_user']))
                                <a href="{{ route('userandpermission.user.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>@lang('Create user')
                                </a>
                            @endif
                            @if (Gate::check('check_user_permission', ['delete_user']) && is_null($detail->deleted_at))
                                <button class="btn btn-danger btn-remove" data-id="{{ $detail->id }}">
                                    <i class="fas fa-times mr-2"></i>@lang('Delete')
                                </button>
                            @endif
                            @if (Gate::check('check_user_permission', ['edit_user']))
                                <a href="{{ route('userandpermission.user.edit', ['id' => $detail->id]) }}" class="btn btn-info">
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
                                        <label class="col-form-label col-md-3">@lang('Username')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->username }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Full name')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">@lang('Status')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="{{ $detail->is_active ? __('Actived') : __('Not actived') }}" disabled>
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
                            @include('userandpermission::user.partials.tabs')
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('userandpermission.user.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>@lang('Back')
                        </a>
                        @if (Gate::check('check_user_permission', ['edit_user']))
                            <a href="{{ route('userandpermission.user.edit', ['id' => $detail->id]) }}" class="btn btn-info">
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
