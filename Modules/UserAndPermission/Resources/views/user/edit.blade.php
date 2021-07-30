@extends('userandpermission::layouts.master')
@section('title', __('Edit user'))
@section('content')
@php
    $parentPage = [['text' => __('Users list'), 'route' => 'userandpermission.user.index']];
@endphp
<x-userandpermission-headerpage current-page="{{ __('Edit user') }}" :parent-page="$parentPage" />
@isset ($detail)
<section class="content">
<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('userandpermission.user.update', ['id' => $detail->id]) }}"
                    method="POST" id="form-submit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="user_id" value="{{ $detail->id }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('userandpermission.user.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>@lang('Back')
                                </a>
                                <a href="{{ route('userandpermission.user.show', ['id' => $detail->id]) }}" class="btn btn-default">
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
                                            <label for="name" class="col-form-label col-md-3">@lang('Full name') <span class="text-danger">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $detail->name ?? null) }}" maxlength="250"
                                                    id="name" name="name" autocomplete="off">
                                                    @error('name')
                                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-form-label col-md-3">Email <span class="text-danger">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="name@example.com" value="{{ old('email', $detail->email ?? null) }}"
                                                    maxlength="250" id="email" name="email" autocomplete="off">
                                                    @error('email')
                                                        <label id="email-error" class="error" for="email">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">@lang('Status')</label>
                                            <div class="col-md-9">
                                                <select name="is_active" id="is_active" class="form-control">
                                                    <option value="1" {{ $detail->is_active ? 'selected' : '' }}>@lang('Active')</option>
                                                    <option value="0" {{ $detail->is_active ? '' : 'selected' }}>@lang('Deactive')</option>
                                                </select>
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
                                <i class="fas fa-arrow-left mr-2"></i>@lang('Back')
                            </a>
                            <a href="{{ route('userandpermission.user.show', ['id' => $detail->id]) }}" class="btn btn-default">
                                <i class="fas fa-ban mr-2"></i>@lang('Cancel')
                            </a>
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
<script src="{{ asset('static/backend/js/user.js') }}"></script>
@endpush
