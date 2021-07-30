<div class="table-responsive pt-3">
    <table class="table text-nowrap table-head-fixed table-striped" style="max-height: 640px;" id="table-users">
        <thead>
            <tr>
                @if ($readOnly)
                    <th width="60">#</th>
                @else
                    <th width="60">
                        <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                            <input type="checkbox" id="select-all-user" {{ isset($selectAllUsers) && $selectAllUsers ? 'checked' : '' }}>
                            <label for="select-all-user"></label>
                        </div>
                    </th>
                    <th width="60">#</th>
                @endif
                <th>@lang('Username')</th>
                <th>@lang('Full name')</th>
                <th>@lang('Email')</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($list_users) && count($list_users) > 0)
                @foreach ($list_users as $index => $item)
                    <tr>
                        @if($readOnly)
                            <td>{{ $index + 1 }}</td>
                        @else
                            <td style="outline: none;">
                                <div class="icheck-{{ $color ?? 'primary' }} d-inline">
                                    <input type="checkbox" id="select-user{{ $item['id'] }}" class="select-all-user" name="user_ids[]"
                                        value="{{ $item['id'] }}" {{ isset($item['selected']) && $item['selected'] == true ? 'checked' : '' }}>
                                    <label for="select-user{{ $item['id'] }}"></label>
                                </div>
                            </td>
                            <td>{{ $item['id'] }}</td>
                        @endif
                        <td>{{ $item['username'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['email'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
