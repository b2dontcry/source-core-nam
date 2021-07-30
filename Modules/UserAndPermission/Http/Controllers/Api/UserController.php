<?php

namespace Modules\UserAndPermission\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Http\Requests\UserRequest;
use Modules\UserAndPermission\Repositories\Contracts\User;
use Modules\UserAndPermission\Models\PermissionUser;

class UserController extends Controller
{
    /**
     * @var \Modules\UserAndPermission\Repositories\Contracts\User
     */
    private $user;

    /**
     * @var \Modules\UserAndPermission\Models\PermissionUser
     */
    private $permissionUser;

    public function __construct(User $user, PermissionUser $permissionUser)
    {
        $this->user = $user;
        $this->permissionUser = $permissionUser;
    }
    /**
     * Lấy danh sách tài khoản người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        if (isset($filter['is_active']) && $filter['is_active'] == -1) {
            unset($filter['is_active']);
        }

        $users = $this->user->getListPagination($filter);

        return nRes($users['data'], __('message.success'));
    }

    /**
     * Xử lý tạo tài khoản.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = $this->user->create($data);

        return nRes($user['data'], $user['message'], $user['status']);
    }

    /**
     * Lấy thông tin tài khoản.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->getDetail($id);

        return nRes([
            'user' => $user['data'],
        ], $user['message'], $user['status']);
    }

    /**
     * Xử lý cập nhật tài khoản.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        $result = $this->user->update($data, $id);

        return nRes($result['data'], $result['message'], $result['status']);
    }

    /**
     * Xử lý cập nhật trạng thái tài khoản.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->only(['status']);
        $result = $this->user->updateStatus($id, $status['status']);

        return nRes(['id' => $id], $result['message'], $result['status']);
    }

    /**
     * Xử lý xóa tài khoản.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->user->delete($id);

        return nRes(['id' => $id], $result['message'], $result['status']);
    }

    /**
     * Xóa vĩnh viễn tài khoản.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete($id)
    {
        if (auth()->user()->is_admin) {
            $user = $this->user->withTrashed()->find($id);
            if (is_null($user)) {
                return nRes(
                    ['id' => $id],
                    __('userandpermission::message.delete_failed',
                    ['text' => 'tài khoản']
                ), 404);
            }

            $this->removePermissionInUser($id);
            $user->forceDelete();

            return nRes(['id' => $id], __('userandpermission::message.delete_success', ['text' => 'tài khoản']));
        }

        return nRes(['id' => $id], __('userandpermission::message.delete_failed', ['text' => 'tài khoản']), 403);
    }

    /**
     * Kiểm tra và xóa quyền của tài khoản.
     *
     * @param  int  $user_id
     * @return void
     */
    private function removePermissionInUser($user_id)
    {
        $this->permissionUser->remove([['user_id', '=', $user_id]]);
    }

    /**
     * Xử lý khôi phục tài khoản đã bị xóa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $user = $this->user->withTrashed()->find($id);
        if (! is_null($user)) {
            $user->restore();
        }
    }
}
