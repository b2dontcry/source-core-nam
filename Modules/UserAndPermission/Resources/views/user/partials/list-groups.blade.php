<div class="table-responsive pt-4">
    <table class="table text-nowrap table-head-fixed table-head-fixed table-striped" style="max-height: 640px;"  id="table-groups">
        <thead>
            <tr>
                @if ($readOnly)
                    <th width="60">#</th>
                @else
                    <th width="60">
                        <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                            <input type="checkbox" id="select-all-group" {{ isset($selectAllGroups) && $selectAllGroups ? 'checked' : '' }}>
                            <label for="select-all-group"></label>
                        </div>
                    </th>
                    <th width="60">#</th>
                @endif
                <th>@lang('Name')</th>
                <th>@lang('Description')</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($list_groups) && count($list_groups) > 0)
                @foreach ($list_groups as $index => $item)
                    <tr>
                        @if($readOnly)
                            <td>{{ $index + 1 }}</td>
                        @else
                            <td style="outline: none;">
                                <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                                    <input type="checkbox" id="select-group{{ $item['id'] }}" class="select-all-group" name="group_ids[]"
                                    value="{{ $item['id'] }}" {{ isset($item['selected']) && $item['selected'] == true ? 'checked' : '' }}>
                                    <label for="select-group{{ $item['id'] }}"></label>
                                </div>
                            </td>
                            <td>{{ $item['id'] }}</td>
                        @endif
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['description'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
