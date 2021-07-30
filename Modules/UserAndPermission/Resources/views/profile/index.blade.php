@extends('userandpermission::layouts.master')
@section('title', __('Profile'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Profile') }}" />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="POST" id="form-profile">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-3">
                                                @lang('Username')
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" value="{{ auth()->user()->username }}"
                                                    class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-form-label col-md-3">
                                                @lang('Full name') <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" value="{{ auth()->user()->name }}"
                                                    name="name" id="name" class="form-control input-edit" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-form-label col-md-3">
                                                @lang('Email') <span class="text-danger">(*)</span>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="email" value="{{ auth()->user()->email }}"
                                                    name="email" id="email" class="form-control input-edit" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10">
                                        <div class="form-group row">
                                            <label for="email" class="col-form-label col-md-3">
                                                @lang('Mode check IP')
                                            </label>
                                            <div class="col-md-9">
                                                <select name="mode_check_ip" id="mode_check_ip" class="form-control">
                                                    <option value="no">@lang('No')</option>
                                                    <option value="black_list">@lang('Black list')</option>
                                                    <option value="white_list">@lang('White list')</option>
                                                </select>
                                                <small class="text-muted">@lang('No: Bypass IP check; Black list: Do not allow login with the IPs in the list; White list: Only allow login with the IPs in the list')</small>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-form-label col-md-3">
                                                @lang('IP address list')
                                            </label>
                                            <div class="col-md-9">
                                                <select name="user_ips" id="user_ips" class="form-control">
                                                    <option value="no">@lang('No')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button"  class="btn btn-primary btn-edit"><i class="fas fa-edit mr-2"></i>@lang('Edit')</button>
                            <button type="button" class="btn btn-success btn-save d-none"><i class="fas fa-check mr-2"></i>@lang('Save')</button>
                            <button type="button" class="btn btn-danger btn-cancel d-none"><i class="fas fa-ban mr-2"></i>@lang('Cancel')</button>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-10">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">
                                            @lang('Latest login')
                                        </label>
                                        <label class="col-form-label col-md-9">
                                            {{ auth()->user()->latest_login }}
                                        </label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">
                                            @lang('Status')
                                        </label>
                                        <label class="col-form-label col-md-9">
                                            {{ auth()->user()->is_active ? __('Actived') : __('Not actived') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script src="{{ asset('static/backend/js/user.js') }}"></script>
@endpush
