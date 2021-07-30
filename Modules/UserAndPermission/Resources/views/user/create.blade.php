@extends('userandpermission::layouts.master')
@section('title', __('Create user'))
@section('content')
@php
    $parentPage = [['text' => __('Users list'), 'route' => 'userandpermission.user.index']];
@endphp
<x-userandpermission-headerpage current-page="{{ __('Create user') }}" :parent-page="$parentPage" />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('userandpermission.user.store') }}" method="POST" id="form-submit">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('userandpermission.user.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i>@lang('Back')
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
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10">
                                        <div class="form-group row">
                                            <label for="name" class="col-form-label col-md-3">@lang('Full name') <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" maxlength="250"
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
                                                placeholder="name@example.com" value="{{ old('email') }}" maxlength="250"
                                                id="email" name="email" autocomplete="off">
                                                @error('email')
                                                    <label id="email-error" class="error" for="email">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="username" class="col-form-label col-md-3">@lang('Username') <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username') }}" maxlength="250"
                                                id="username" name="username" autocomplete="off">
                                                @error('username')
                                                    <label id="username-error" class="error" for="username">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-form-label col-md-3">@lang('Password') <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                value="{{ old('password') }}" maxlength="32"
                                                id="password" name="password" autocomplete="off">
                                                @error('password')
                                                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password_confirmation" class="col-form-label col-md-3">@lang('Password confirmation') <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                value="{{ old('password_confirmation') }}" maxlength="32"
                                                id="password_confirmation" name="password_confirmation" autocomplete="off">
                                                @error('password_confirmation')
                                                    <label id="password_confirmation-error" class="error" for="password_confirmation">{{ $message }}</label>
                                                @enderror
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
@endsection
@push('scripts')
<script src="{{ asset('static/backend/js/user.js') }}"></script>
@endpush
