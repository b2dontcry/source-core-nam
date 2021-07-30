@extends('userandpermission::layouts.master')
@section('title', __('Setting'))
@section('content')
<x-userandpermission-headerpage current-page="{{ __('Setting') }}" />
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
                                        <label for="language" class="col-form-label col-md-3">@lang('Language')</label>
                                        <div class="col-md-9">
                                            <select name="language" id="language" class="form-control">
                                                @foreach ($languages as $key => $language)
                                                    <option value="{{ $key }}"
                                                        @if (! is_null(auth()->user()->setting))
                                                            {{auth()->user()->setting->language == $key ? 'selected' : ''}}
                                                        @elseif (app()->isLocale($key))
                                                            selected
                                                        @endif
                                                    >
                                                        {{ $language }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="theme" class="col-form-label col-md-3">@lang('Theme')</label>
                                        <div class="col-md-9">
                                            <select name="theme" id="theme" class="form-control">
                                                @foreach ($themes as $theme)
                                                    @php
                                                        if ($theme != 'default') {
                                                            [$color, $backGround] = explode('-', $theme);
                                                            $class = "bg-{$backGround} text-{$color}";
                                                        }
                                                    @endphp
                                                    <option value="{{ $theme }}" class="{{ $class ?? ''  }}"
                                                        @if (! is_null(auth()->user()->setting))
                                                            {{auth()->user()->setting->theme == $theme ? 'selected' : ''}}
                                                        @elseif ($theme == 'default')
                                                            selected
                                                        @endif
                                                    >
                                                        {{ $theme }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-secondary" name="reset" value="1">
                                <i class="fas fa-redo mr-2"></i>@lang('Reset settings')
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>@lang('Save')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
