<div class="modal fade" id="m_history_detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('History detail')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (isset($detail) && $detail != null)
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>@lang('Username')</th>
                                <td>{{ $detail->user->username }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Full name')</th>
                                <td>{{ $detail->user->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Action')</th>
                                <td>{{ sprintf(__(("histories.{$detail->table_name}.{$detail->key}.action")), $detail->user->username) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Time')</th>
                                <td>{{ date('d/m/Y H:i:s', strtotime($detail->created_at)) }}</td>
                            </tr>
                            <tr>
                                <th>IP</th>
                                <td>{{ $detail->ip_address }}</td>
                            </tr>
                            <tr>
                                <th>@lang('OS')</th>
                                <td>{{ $detail->platform }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Browser')</th>
                                <td>{{ $detail->browser }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Device')</th>
                                <td>{{ $detail->device }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Device family')</th>
                                <td>{{ $detail->device_family }}</td>
                            </tr>
                            <tr>
                                <th>@lang('Device model')</th>
                                <td>{{ $detail->device_model }}</td>
                            </tr>
                            @if (! empty($detail->data))
                            <tr>
                                <th colspan="2" class="text-center">
                                    <h4>@lang('Data information')</h4>
                                </th>
                            </tr>
                            @php
                                $dataInfo = json_decode($detail->data, true);
                                foreach ($dataInfo as $key => $value) {
                                    echo '<tr><th>'.__($key).'</th><td>'.$value.'</td></tr>';
                                }
                            @endphp
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
