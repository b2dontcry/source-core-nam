@extends('userandpermission::layouts.master')
@section('title', __('Change password'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Change password') }}" />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="POST" id="form-filter">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10">
                                        <div class="form-group row">
                                            <label for="current-password" class="col-form-label col-md-3">@lang('Current password') <span class="text-danger">(*)</span></label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control @error('current-password') is-invalid @enderror"
                                                value="{{ old('current-password') }}" maxlength="32"
                                                id="current-password" name="current-password" autocomplete="off">
                                                @error('current-password')
                                                    <label id="current-password-error" class="error" for="current-password">{{ $message }}</label>
                                                @enderror
                                                @if (session('status'))
                                                    <label id="current-password-error" class="error" for="current-password">{{ session('status') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-form-label col-md-3">@lang('New password') <span class="text-danger">(*)</span></label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                value="{{ old('password') }}" maxlength="32"
                                                id="password" name="password" autocomplete="off"
                                                placeholder="{{ __('The password must include letters, capital letters, numbers, special characters and a minimum of 8 characters.') }}">
                                                <small class="text-muted">{{ __('The password must include letters, capital letters, numbers, special characters and a minimum of 8 characters.') }}</small><br/>
                                                @error('password')
                                                    <label id="password-error" class="error" for="password">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password_confirmation" class="col-form-label col-md-3">@lang('Password confirmation') <span class="text-danger">(*)</span></label>
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
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-exchange-alt mr-2"></i>@lang('Change password')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
