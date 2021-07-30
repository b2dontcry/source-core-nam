@php
    $setting = auth()->user()->setting;
    $color = is_null($setting) ? 'primary' : $setting->color;
    $routeName = Route::currentRouteName();
    $readOnly = $routeName == 'userandpermission.user.show';
    $selectAllGroups ??= null;
    $selectAllPermissions ??= null;

@endphp
<ul class="nav nav-tabs" id="content-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-group-tab" data-toggle="pill" href="#content-group"
        role="tab" aria-controls="content-group" aria-selected="true">@lang('Groups')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="content-permission-tab" data-toggle="pill" href="#content-permission"
        role="tab" aria-controls="content-permission" aria-selected="false">@lang('Permissions')</a>
    </li>
</ul>
<div class="tab-content" id="content-tabContent">
    <div class="tab-pane fade show active" id="content-group" role="tabpanel" aria-labelledby="content-group-tab">
        @include('userandpermission::user.partials.list-groups', compact('list_groups', 'readOnly', 'color', 'selectAllGroups'))
    </div>
    <div class="tab-pane fade" id="content-permission" role="tabpanel" aria-labelledby="content-permission-tab">
        <div id="list-permission">
            @include('userandpermission::user.partials.list-permissions', compact('list_permissions', 'readOnly', 'color', 'selectAllPermissions'))
        </div>
    </div>
</div>
