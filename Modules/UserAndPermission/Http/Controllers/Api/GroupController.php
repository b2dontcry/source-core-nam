<?php

namespace Modules\UserAndPermission\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Http\Requests\StoreGroupRequest;
use Modules\UserAndPermission\Http\Requests\UpdateGroupRequest;
use Modules\UserAndPermission\Repositories\Contracts\Group;
use Modules\UserAndPermission\Models\GroupPermission;

class GroupController extends Controller
{
    /**
     * @var \Modules\UserAndPermission\Repositories\Contracts\Group
     */
    private $group;

    /**
     * @var \Modules\UserAndPermission\Models\GroupPermission
     */
    private $groupPermission;

    public function __construct(Group $group, GroupPermission $groupPermission)
    {
        $this->group = $group;
        $this->groupPermission = $groupPermission;
    }

    /**
     * Lấy danhs sách nhóm quyền.
     *
     * @param  \Illumianate\Http\Request  $request
     * @return \Illumianate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        $groups = $this->group->getList($filter);

        return nRes($groups, __('userandpermission::message.success'));
    }

    /**
     * Xử lý tạo mới nhóm quyền.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\StoreGroupRequest  $request
     * @return \Illumianate\Http\JsonResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $group = $this->group->add($data);

        if (isset($data['permission_ids']) && ! empty($data['permission_ids'])) {
            $this->addPermissionsToGroup($data['permission_ids'], $group->id);
        }

        if (isset($data['user_ids']) && ! empty($data['user_ids'])) {
            $this->addUsersToGroup($data['user_ids'], $group->id);
        }

        return nRes($data);
    }

    /**
     * Thêm quyền vào nhóm quyền.
     *
     * @param  array  $permission_id
     * @param  int  $group_id
     * @return void
     */
    private function addPermissionsToGroup(array $permission_ids, $group_id)
    {
        $data = [];

        foreach ($permission_ids as $permission_id) {
            $data[] = [
                'group_id' => $group_id,
                'permission_id' => $permission_id,
            ];
        }

        $this->groupPermission->adds($data, $group_id);
    }

    private function addUsersToGroup(array $user_ids, $group_id)
    {
        $data = [];

        foreach ($user_ids as $user_id) {
            $data[] = [
                'user_id' => $user_id,
                'group_id' => $group_id,
            ];
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illumianate\Http\JsonResponse
     */
    public function show($id)
    {
        $group = $this->group->getDetail($id);

        return nRes([
            'group' => $group['data']
        ], $group['message'], $group['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\UpdateGroupRequest  $request
     * @param int $id
     * @return \Illumianate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illumianate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
