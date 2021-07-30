<?php

namespace Modules\UserAndPermission\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\UserAndPermission\Models\SessionToken;
use Illuminate\Support\Facades\DB;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (! $this->checkToken()) {
            $user = DB::table('users')->where([
                ['id', '=',auth()->id()],
                ['is_active', '=', 1],
            ])->whereNull('deleted_at')->first();

            if (is_null($user)) {
                return redirect()->route('logout');
            }

            app(\Modules\UserAndPermission\Repositories\Contracts\User::class)->setPermissionUser();
            $token = (new SessionToken())->getToken(auth()->id())->token;
            $request->session()->put('user_token', $token);
        }

        $permissions = $request->session()->get('user_permissions', function () {
            return [];
        });

        if (! auth()->user()->is_admin && ! in_array($permission, $permissions)) {
            abort(403);
        }

        return $next($request);
    }

    /**
     * Kiểm tra token của user hiện tại có trùng khớp không.
     *
     * @return bool
     */
    public function checkToken()
    {
        $sessionToken = new SessionToken;

        return $sessionToken->checkUserToken(auth()->id(), session()->get('user_token'));
    }
}
