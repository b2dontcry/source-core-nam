<div class="table-responsive pt-3">
    <table class="table text-nowrap table-head-fixed table-striped" style="max-height: 640px;" id="table-permissions">
        <thead>
            <tr>
                @if ($readOnly)
                    <th width="60">#</th>
                @else
                    <th width="60">
                        <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                            <input type="checkbox" id="select-all-permission" {{ isset($selectAllPermissions) && $selectAllPermissions ? 'checked' : '' }}>
                            <label for="select-all-permission"></label>
                        </div>
                    </th>
                    <th width="60">#</th>
                @endif
                <th>@lang('Name')</th>
                <th>@lang('Code')</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($list_permissions) && count($list_permissions) > 0)
                @foreach ($list_permissions as $index => $item)
                    <tr>
                        @if($readOnly)
                            <td>{{ $index + 1 }}</td>
                        @else
                            <td style="outline: none;">
                                <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                                    <input type="checkbox" id="select-permission{{ $item['id'] }}" class="select-all-permission" name="permission_ids[]"
                                    value="{{ $item['id'] }}" {{ isset($item['selected']) && $item['selected'] == true ? 'checked' : '' }}>
                                    <label for="select-permission{{ $item['id'] }}"></label>
                                </div>
                            </td>
                            <td>{{ $item['id'] }}</td>
                        @endif
                        <td>@lang($item['name'])</td>
                        <td>{{ $item['code'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
