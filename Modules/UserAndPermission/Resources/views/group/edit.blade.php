@extends('userandpermission::layouts.master')
@section('title', __('Edit group'))
@section('content')
@php
    $parentPage = [['text' => __('Groups list'), 'route' => 'userandpermission.group.index']];
@endphp
<x-userandpermission-headerpage current-page="{{ __('Edit group') }}" :parent-page="$parentPage" />
@isset ($detail)
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('userandpermission.group.update', ['id' => $detail->id]) }}" method="POST" id="form-submit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="group_id" id="group_id" value="{{ $detail->id }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('userandpermission.group.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>@lang('Back')
                                </a>
                                <a href="{{ route('userandpermission.group.show', ['id' => $detail->id]) }}" class="btn btn-default">
                                    <i class="fas fa-ban mr-2"></i>@lang('Cancel')
                                </a>
                                @if (Gate::check('check_user_permission', ['create_group']))
                                    <a href="{{ route('userandpermission.group.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>@lang('Create group')
                                    </a>
                                @endif
                                @if (Gate::check('check_user_permission', ['delete_group']) && is_null($detail->deleted_at))
                                    <button class="btn btn-danger btn-remove">
                                        <i class="fas fa-times mr-2"></i>@lang('Delete')
                                    </button>
                                @endif
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-save" data-type="submit">
                                        <i class="fas fa-save mr-2"></i>@lang('Save')
                                    </button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"></button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item btn-save" href="javascript:void(0)"  data-type="ajax-continue">
                                            <i class="fas fa-save mr-2"></i>@lang('Save and continue')
                                        </a>
                                        <a class="dropdown-item btn-save" href="javascript:void(0)" data-type="ajax-quit">
                                            <i class="fas fa-save mr-2"></i>@lang('Save and quit')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10">
                                        <div class="form-group row">
                                            <label for="name" class="col-form-label col-md-3">@lang('Name') <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $detail->name }}" maxlength="250"
                                                id="name" name="name" autocomplete="off">
                                                @error('name')
                                                    <label id="name-error" class="error" for="name">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-form-label col-md-3">@lang('Description')</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                                value="{{ $detail->description }}" maxlength="250"
                                                id="description" name="description" autocomplete="off">
                                                @error('description')
                                                    <label id="description-error" class="error" for="description">{{ $message }}</label>
                                                @enderror
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
                                <i class="fas fa-arrow-left mr-2"></i>@lang('Back')
                            </a>
                            <a href="{{ route('userandpermission.group.show', ['id' => $detail->id]) }}" class="btn btn-default">
                                <i class="fas fa-ban mr-2"></i>@lang('Cancel')
                            </a>
                            @if (Gate::check('check_user_permission', ['create_user']))
                                    <a href="{{ route('userandpermission.user.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus mr-2"></i>@lang('Create user')
                                    </a>
                                @endif
                                @if (Gate::check('check_user_permission', ['delete_user']) && is_null($detail->deleted_at))
                                    <button class="btn btn-danger btn-remove">
                                        <i class="fas fa-times mr-2"></i>@lang('Delete')
                                    </button>
                                @endif
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-save" data-type="submit">
                                    <i class="fas fa-save mr-2"></i>@lang('Save')
                                </button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item btn-save" href="javascript:void(0)"  data-type="ajax-continue">
                                        <i class="fas fa-save mr-2"></i>@lang('Save and continue')
                                    </a>
                                    <a class="dropdown-item btn-save" href="javascript:void(0)" data-type="ajax-quit">
                                        <i class="fas fa-save mr-2"></i>@lang('Save and quit')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endisset
@endsection
@push('scripts')
<script src="{{ asset('static/backend/js/group.js') }}"></script>
@endpush
