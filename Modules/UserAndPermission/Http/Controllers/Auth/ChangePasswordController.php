<?php

namespace Modules\UserAndPermission\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Modules\UserAndPermission\Models\History;

class ChangePasswordController extends Controller
{
    /**
     * Hiển thị trang đổi mật khẩu.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChangePasswordPage()
    {
        if (! $this->guard()->check()) {
            return redirect()->route('login');
        }

        return view('userandpermission::auth.change-password');
    }

    /**
     * Xử lý đổi mật khẩu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current-password' => ['required', 'max:32'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if (! $this->guard()->check()) {
            return redirect()->route('login');
        } elseif (! Hash::check($data['current-password'], $this->guard()->user()->password)) {
            return back()->with('status', __('message.the_current_password_invalid'));
        } elseif ($data['current-password'] == $data['password']) {
            return back()->with('status', __('message.new_old_pass_must_diff'));
        }

        $user = $this->guard()->user();
        $user->password = $data['password'];

        if (is_null($user->latest_login)) {
            (new History())->add('users', 'login');
            $user->latest_login = now();
        }

        $user->save();

        return redirect()->route('home');
    }

    /**
     * Lấy yêu cầu xác thực hiện tại.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth('web');
    }
}
