<?php

namespace Modules\UserAndPermission\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Modules\UserAndPermission\Repositories\Contracts\User as UserContract;
use Modules\UserAndPermission\Models\User;
use Modules\UserAndPermission\Models\{
    Group,
    History,
    LoginFailed,
    Permission,
    SessionToken,
    GroupUser,
    PermissionUser
};

class UserRepository implements UserContract
{
    /**
     * @var \Modules\UserAndPermission\Models\User
     */
    protected $user;

    /**
     * @var \Modules\UserAndPermission\Models\History
     */
    protected $history;

    /**
     * @var \Modules\UserAndPermission\Models\Group
     */
    protected $group;

    /**
     * @var \Modules\UserAndPermission\Models\Permission
     */
    protected $permission;

    /**
     * @var \Modules\UserAndPermission\Models\GroupUser
     */
    protected $groupUser;

    /**
     * @var \Modules\UserAndPermission\Models\PermissionUser
     */
    protected $permissionUser;

    /**
     * @var \Modules\UserAndPermission\Models\SessionToken
     */
    protected $sessionToken;

    public function __construct(
        User $user,
        History $history,
        Group $group,
        Permission $permission,
        GroupUser $groupUser,
        PermissionUser $permissionUser,
        SessionToken $sessionToken
    ) {
        $this->user = $user;
        $this->history = $history;
        $this->group = $group;
        $this->permission = $permission;
        $this->groupUser = $groupUser;
        $this->permissionUser = $permissionUser;
        $this->sessionToken = $sessionToken;
    }

    /**
     * Lấy danh sách tất cả tài khoản người dùng.
     *
     * @param  $arg
     * @return array
     */
    public function getListAll(array $filter = [])
    {
        $filter['per_page'] = 0;

        return $this->getListPagination($filter);
    }

    /**
     * Lấy danh sách tài khoản người dùng có phân trang.
     *
     * @param  array  $filter
     * @return array
     */
    public function getListPagination(array $filter = [])
    {
        if (isset($filter['per_page']) && $filter['per_page'] < 0) {
            return collect();
        }

        $users = $this->user->getList($filter);

        return [
            'filter' => $filter,
            'data' => $users
        ];
    }

    /**
     * Lấy thông tin tài khoản người dùng.
     *
     * @param  int  $id
     * @return array
     */
    public function getDetail($id)
    {
        $status = 404;
        $message = __('message.failed');
        $user = $this->user->getDetail($id);

        if (! is_null($user)) {
            $status = 200;
            $message = __('message.success');
            $groups = $this->group->getForEdit($user->groups->pluck('id'));
            $permissions = $this->permission->getForEdit($user->permissions->pluck('id'));
        }

        return [
            'status' => $status,
            'message' => $message,
            'data' => $user,
            'groups' => $groups ?? [],
            'permissions' => $permissions ?? [],
        ];
    }

    /**
     * Thêm tài khoản người dùng.
     *
     * @param  array  $data
     * @return array
     */
    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $this->user->fill(Arr::only($data, ['username', 'password', 'email', 'name']));
            $this->user->created_at = now();
            $this->user->updated_at = now();

            $this->user->save();

            if (isset($data['group_ids'])) {
                $this->user->groups()->sync($data['group_ids']);
            }

            if (isset($data['permission_ids'])) {
                $this->user->permissions()->sync($data['permission_ids']);
            }

            DB::commit();

            return [
                'status' => 201,
                'message' => __('message.create_success', ['attribute' => 'user']),
                'data' => $this->user,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 406,
                'message' => __('message.create_failed', ['attribute' => 'user']),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Cập nhật tài khoản người dùng.
     *
     * @param  array  $data
     * @param  int  $id
     * @return array
     */
    public function update(array $data, $id)
    {
        $data['group_ids'] = $data['group_ids'] ?? [];
        $data['permission_ids'] = $data['permission_ids'] ?? [];

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->fill(Arr::only($data, ['email', 'name', 'is_active']));
            $user->updated_at = now();

            $user->save();

            $this->updateGroupForUser($user, $data['group_ids']);
            $this->updatePermissionForUser($user, $data['permission_ids']);

            DB::commit();

            return [
                'status' => 200,
                'message' => __('message.update_success', ['attribute' => 'user']),
                'data' => null,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 400,
                'message' => __('message.update_failed', ['attribute' => 'user']),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Cập nhật nhóm quyền cho tài khoản người dùng.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @param  array  $groups
     * @return void
     */
    private function updateGroupForUser(User $user, array $groups)
    {
        $beforeChange = $user->groups->pluck('id')->all();

        if (count(array_diff($beforeChange, $groups)) || count(array_diff($groups, $beforeChange))) {
            $user->groups()->sync($groups);
            $this->sessionToken->addToken($user->id);
        }
    }

    /**
     * Cập nhật quyền cho tài khoản người dùng.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @param  array  $permissions
     * @return void
     */
    private function updatePermissionForUser(User $user, array $permissions)
    {
        $beforeChange = $user->permissions->pluck('id')->all();

        if (count(array_diff($beforeChange, $permissions)) || count(array_diff($permissions, $beforeChange))) {
            $user->permissions()->sync($permissions);
            $this->sessionToken->addToken($user->id);
        }
    }

    /**
     * Gỡ bỏ nhóm quyền khỏi tài khoản người dùng.
     *
     * @param  int  $userId
     * @return void
     */
    public function removeGroupsInUser($userId)
    {
        $this->groupUser->remove($userId, 'group_user');
    }

    /**
     * Gỡ bỏ quyền khỏi tài khoản người dùng.
     *
     * @param  int  $userId
     * @return void
     */
    public function removePermissionsInUser($userId)
    {
        $this->permissionUser->remove($userId);
    }

    /**
     * Cập nhật trạng thái tài khoản người dùng.
     *
     * @param  int  $id
     * @param  int|bool
     * @return void
     */
    public function updateStatus($id, $status)
    {
        $result = $this->user->where('id', $id)->update([
            'is_active' => (int) $status,
            'updated_at' => now(),
        ]);

        if ($result) {
            $this->sessionToken->addToken($id);
            $this->history->add('users', 'update_status');

            return [
                'status' => 200,
                'message' => __('message.update_success'),
            ];
        }

        return [
            'status' => 404,
            'message' => __('message.update_failed'),
        ];
    }

    /**
     * Xóa tài khoản người dùng.
     *
     * @param  int  $id
     * @return array
     */
    public function delete($id)
    {
        $user = $this->user->where([
            ['id', '=', $id],
            ['id', '<>', auth()->id()],
            ['is_admin', '=', 0],
        ])->firstOrFail();

        $result = $user->delete();

        if ($result) {
            $this->sessionToken->addToken($id);

            return [
                'status' => 200,
                'message' => __('message.delete_success', ['attribute' => 'user']),
            ];
        }

        return [
            'status' => 400,
            'message' => __('message.delete_failed', ['attribute' => 'user']),
        ];
    }

    /**
     * Xóa vĩnh viễn tài khoản người dùng.
     *
     * @param  int  $id
     * @return array
     */
    public function forceDelete($id)
    {
        if (auth()->user()->cannot('delete')) {
            return [
                'status' => 403,
                'message' => __('message.delete_failed', ['attribute' => 'user']),
            ];
        }

        $user = $this->user->where([
            ['id', '=', $id],
            ['id', '<>', auth()->id()],
            ['is_admin', '=', 0],
        ])->withTrashed()->firstOrFail();

        $result = $user->forceDelete();

        if ($result) {
            $this->removeGroupsInUser($id);
            $this->removePermissionsInUser($id);
            $this->sessionToken->addToken($id);

            return [
                'status' => 200,
                'message' => __('message.delete_success', ['attribute' => 'user']),
            ];
        }

        return [
            'status' => 400,
            'message' => __('message.delete_failed', ['attribute' => 'user']),
        ];
    }

    /**
     * Xử lý khôi phục tài khoản người dùng.
     *
     * @param  int  $id
     * @return array
     */
    public function restore($id)
    {
        if (! auth()->user()->is_admin) {
            return [
                'status' => 403,
                'message' => __('message.restore_failed', ['attribute' => 'user']),
            ];
        }

        $user = $this->user->where([
            ['id', '=', $id],
            ['id', '<>', auth()->id()],
            ['is_admin', '=', 0],
        ])->withTrashed()->firstOrFail();

        $result = $user->restore();

        if ($result) {
            return [
                'status' => 200,
                'message' => __('message.restore_success', ['attribute' => 'user']),
            ];
        }

        return [
            'status' => 400,
            'message' => __('message.restore_failed', ['attribute' => 'user']),
        ];
    }

    /**
     * Xử lý đăng nhập.
     *
     * @param  array  $credentials
     * @return array
     */
    public function handleLogin(array $credentials)
    {
        $loginFailed = new LoginFailed();

        if ($loginFailed->countLoginFailed($credentials['username']) >= 5) {
            return [
                'status' => 401,
                'data' => null,
                'message' => __('message.user_locked_day', ['num' => 24]),
            ];
        }

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user->is_active) {
                if (is_null($user->latest_login)) {
                    return [
                        'status' => 200,
                        'message' => 'first time',
                        'data' => 'first time',
                    ];
                }

                $this->history->add('users', 'login');
                $user->updateLatestLogin($user->id);

                return [
                    'status' => 200,
                    'data' => auth()->user(),
                    'message' => __('message.login_success'),
                ];
            }

            auth()->logout();

            return [
                'status' => 422,
                'data' => $credentials,
                'message' => __('message.user_locked'),
            ];
        }

        $loginFailed->isLoginFailed($credentials['username']);

        return [
            'status' => 422,
            'data' => ['messages' => 'Đăng nhập thất bại!'],
            'message' => __('message.login_failed')
        ];
    }

    /**
     * Thiết lập quyền cho tài khoản sau khi đăng nhập.
     *
     * @return void
     */
    public function setPermissionUser()
    {
        if (auth()->check()) {
            session(['user_permissions' => $this->permission->getPermissionUser(auth()->id())]);
        }
    }

    /**
     * Lưu token đăng nhập.
     *
     * @return void
     */
    public function saveSessionToken()
    {
        $sessionToken = new SessionToken();
        $token = $sessionToken->addToken(auth()->id())->token;
        session(['user_token' => $token]);
    }
}
