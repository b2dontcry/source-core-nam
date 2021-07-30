<?php

namespace Modules\UserAndPermission\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Modules\UserAndPermission\Repositories\Contracts\Group as GroupContract;
use Modules\UserAndPermission\Models\Group;
use Modules\UserAndPermission\Models\GroupPermission;
use Modules\UserAndPermission\Models\History;
use Modules\UserAndPermission\Models\Permission;
use Modules\UserAndPermission\Models\SessionToken;
use Modules\UserAndPermission\Models\User;
use Modules\UserAndPermission\Models\GroupUser;

class GroupRepository implements GroupContract
{
    /**
     * @var \Modules\UserAndPermission\Models\Group
     */
    private $group;

    /**
     * @var \Modules\UserAndPermission\Models\History
     */
    protected $history;

    /**
     * @var \Modules\UserAndPermission\Models\User
     */
    protected $user;

    /**
     * @var \Modules\UserAndPermission\Models\Permission
     */
    protected $permission;

    /**
     * @var \Modules\UserAndPermission\Models\GroupUser
     */
    protected $groupUser;

    /**
     * @var \Modules\UserAndPermission\Models\GroupPermission
     */
    protected $groupPermission;

    /**
     * @var \Modules\UserAndPermission\Models\SessionToken
     */
    protected $sessionToken;

    public function __construct(
        Group $group,
        History $history,
        User $user,
        Permission $permission,
        groupUser $groupUser,
        GroupPermission $groupPermission,
        SessionToken $sessionToken
    ) {
        $this->group = $group;
        $this->history = $history;
        $this->user = $user;
        $this->permission = $permission;
        $this->groupUser = $groupUser;
        $this->groupPermission = $groupPermission;
        $this->sessionToken = $sessionToken;
    }

    /**
     * Lấy danh sách tất cả nhóm quyền.
     *
     * @param  array  $filter
     * @return array
     */
    public function getListAll(array $filter = [])
    {
        $filter['per_page'] = 0;
        $groups = $this->group->getList($filter);

        return [
            'filter' => $filter,
            'data' => $groups
        ];
    }

    /**
     * Lấy danh sách nhóm quyền có phân trang.
     *
     * @param  array  $filter
     * @return array
     */
    public function getListPagination(array $filter = [])
    {
        if (isset($filter['per_page']) && $filter['per_page'] <= 0) {
            return collect([]);
        }

        $groups = $this->group->getList($filter);

        return [
            'filter' => $filter,
            'data' => $groups
        ];
    }

    /**
     * Lấy thông tin nhóm quyền.
     *
     * @param  int  $id
     * @return array
     */
    public function getDetail($id)
    {
        $status = 404;
        $message = __('message.failed');
        $group = $this->group->getDetail($id);

        if (! is_null($group)) {
            $status = 200;
            $message = __('message.success');
            $users = $this->user->getForEdit($group->users->pluck('id')->toArray());
            $permissions = $this->permission->getForEdit($group->permissions->pluck('id')->toArray());
        }

        return [
            'status' => $status,
            'message' => $message,
            'data' => $group,
            'users' => $users ?? [],
            'permissions' => $permissions ?? [],
        ];
    }

    /**
     * Thêm nhóm quyền.
     *
     * @param  array  $data
     * @return array
     */
    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $this->group->fill(Arr::only($data, ['name', 'description']));
            $this->group->created_by = auth()->id();
            $this->group->updated_by = auth()->id();

            $this->group->save();

            if (isset($data['user_ids'])) {
                $this->group->users()->sync($data['user_ids'] ?? []);
            }

            if (isset($data['permission_ids'])) {
                $this->group->permissions()->sync($data['permission_ids'] ?? []);
            }

            DB::commit();

            return [
                'status' => 201,
                'message' => __('message.create_success', ['attribute' => 'group']),
                'data' => $this->group,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 400,
                'message' => __('message.create_failed', ['attribute' => 'group']),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Cập nhật nhóm quyền.
     *
     * @param  array  $data
     * @param  int  $id
     * @return array
     */
    public function update(array $data, $id)
    {
        $data['user_ids'] = $data['user_ids'] ?? [];
        $data['permission_ids'] = $data['permission_ids'] ?? [];

        try {
            DB::beginTransaction();

            $group = Group::findOrFail($id);
            $group->fill(Arr::only($data, ['name', 'description']));
            $group->updated_by = auth()->id();

            $group->save();

            $this->updateUserForGroup($group, $data['user_ids']);
            $this->updatePermissionForGroup($group, $data['permission_ids']);

            DB::commit();

            return [
                'status' => 200,
                'message' => __('message.update_success', ['attribute' => 'group']),
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 400,
                'message' => __('message.update_failed', ['attribute' => 'group']),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Cập nhật tài khoản cho nhóm quyền.
     *
     * @param  \Modules\UserAndPermission\Models\Group  $group
     * @param  array  $users
     * @return void
     */
    private function updateUserForGroup(Group $group, array $users)
    {
        $beforeChange = $group->users->pluck('id')->all();

        if (count(array_diff($beforeChange, $users)) || count(array_diff($users, $beforeChange))) {
            // code lưu history
            $group->users()->sync($users);
            $this->sessionToken->addToken($group->id);
        }
    }

    /**
     * Cập nhật quyền cho nhóm quyền.
     *
     * @param  \Modules\UserAndPermission\Models\Group  $group
     * @param  array  $permissions
     * @return void
     */
    private function updatePermissionForGroup(Group $group, array $permissions)
    {
        $beforeChange = $group->permissions->pluck('id')->all();

        if (count(array_diff($beforeChange, $permissions)) || count(array_diff($permissions, $beforeChange))) {
            // code lưu history
            $group->permissions()->sync($permissions);
            $this->sessionToken->addToken($group->id);
        }
    }

    /**
     * Xóa tài khoản người dùng khỏi nhóm quyền.
     *
     * @param  int  $groupId
     * @return void
     */
    public function removeUsersInGroup($groupId)
    {
        $this->groupUser->remove($groupId, 'user_group');
    }

    /**
     * Xoá quyền khỏi nhóm quyền.
     *
     * @param  int  $groupId
     * @return void
     */
    public function removePermissionsInGroup($groupId)
    {
        $this->groupPermission->remove($groupId);
    }

    /**
     * Xóa nhóm quyền.
     *
     * @param int  $id
     * @return array
     */
    public function delete($id)
    {
        $group = $this->group->where('id', $id)->firstOrFail();

        $result = $group->delete();

        if ($result) {
            $this->removeUsersInGroup($id);
            $this->removePermissionsInGroup($id);
            $this->sessionToken->addToken($id);

            return [
                'status' => 200,
                'message' => __('message.delete_success', ['attribute' => 'group']),
            ];
        }

        return [
            'status' => 400,
            'message' => __('message.delete_failed', ['attribute' => 'group']),
        ];
    }
}
