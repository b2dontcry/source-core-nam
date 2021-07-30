<?php

namespace Modules\UserAndPermission\Http\Controllers;

use App\Helpers\NName;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Models\History;

class HistoryController extends Controller
{
    /**
     * Hiển thị danh sách lịch sử.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $history = new History;
        $history->clearXDayHistory();
        $list = $history->getList($filter);

        return view('userandpermission::history.index', compact('list', 'filter'));
    }

    /**
     * Hiển thị thông tin chi tiết lịch sử.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $history = new History;
        $detail = $history->find($id);

        return view('userandpermission::history.show', compact('detail'));
    }
}
