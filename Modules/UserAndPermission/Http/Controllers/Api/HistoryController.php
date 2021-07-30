<?php

namespace Modules\UserAndPermission\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Models\History;

class HistoryController extends Controller
{

    /**
     * @var \Modules\UserAndPermission\Models\History
     */
    private $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    /**
     * Lấy danh sách lịch sử.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $data = $this->history->getList($filter);

        return nRes($data, __('userandpermission::message.get_list_success', ['text' => 'lịch sử']));
    }
}
