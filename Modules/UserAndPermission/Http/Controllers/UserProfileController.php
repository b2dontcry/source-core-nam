<?php

namespace Modules\UserAndPermission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Rules\EmailRule;

class UserProfileController extends Controller
{
    /**
     * Hiển thị thông tin tài khoản hiện tại.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('userandpermission::profile.index');
    }

    /**
     * Cập nhật thông tin tài khoản hiện tại.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:150'],
            'email' => ['required', new EmailRule()],
        ]);

        $user = auth()->user();
        $user->name = strip_tags($data['name']);
        $user->email = strtolower($data['email']);
        $user->save();

        return nRes($user, __('message.update_success'));
    }
}
