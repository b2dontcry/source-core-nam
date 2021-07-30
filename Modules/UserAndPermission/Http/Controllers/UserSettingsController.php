<?php

namespace Modules\UserAndPermission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Models\UserSetting;

class UserSettingsController extends Controller
{
    /**
     * Hiển thị thông tin cài đặt của tài khoản người dùng hiện tại.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('userandpermission::settings.index', [
            'languages' => UserSetting::LANGUAGES,
            'themes' => UserSetting::THEMES,
            'colors' => UserSetting::COLORS,
        ]);
    }

    /**
     * Tạo mới hoặc cập nhật thông tin cài đặt của tài khoản người dùng hiện tại.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('reset')) {
            UserSetting::where('user_id', auth()->id())->delete();

            return back();
        }

        $data = $request->only(['language', 'theme']);
        $data['language'] = in_array($data['language'], UserSetting::LANGUAGES_VALID) ? $data['language'] : 'en';
        $data['theme'] = in_array($data['theme'], UserSetting::THEMES) ? $data['theme'] : 'default';
        $data['config'] = json_encode($request->except(['language', 'theme', '_token']));

        UserSetting::updateOrCreate(['user_id' => auth()->id()], $data);

        return back();
    }
}
