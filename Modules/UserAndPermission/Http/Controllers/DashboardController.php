<?php

namespace Modules\UserAndPermission\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Models\SessionToken;
use Modules\UserAndPermission\Repositories\Contracts\User;

class DashboardController extends Controller
{
    /**
     * @var \Modules\UserAndPermission\Repositories\Contracts\User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Trang chủ sau khi đăng nhập thành công.
     *
     * @return \Illuminate\Http\Request
     */
    public function __invoke()
    {
        $sessionToken = new SessionToken();
        $checkToken = $sessionToken->checkUserToken(auth()->id(), session()->get('user_token'));

        if (! $checkToken) {
            $this->user->setPermissionUser();
            $token = $sessionToken->getToken(auth()->id())->token;
            session(['user_token' => $token]);
        }

        return view('userandpermission::index');
    }
}
