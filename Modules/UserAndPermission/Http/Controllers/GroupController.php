<?php

namespace Modules\UserAndPermission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserAndPermission\Http\Requests\GroupRequest;
use Modules\UserAndPermission\Models\Permission;
use Modules\UserAndPermission\Repositories\Contracts\Group;
use Modules\UserAndPermission\Repositories\Contracts\User;

class GroupController extends Controller
{
    /**
     * @var \Modules\UserAndPermission\Repositories\Contracts\User
     */
    private $user;

    /**
     * @var \Modules\UserAndPermission\Repositories\Contracts\Group
     */
    private $group;

    /**
     * @var \Modules\UserAndPermission\Models\Permission
     */
    private $permission;

    public function __construct(User $user, Group $group, Permission $permission)
    {
        $this->user = $user;
        $this->group = $group;
        $this->permission = $permission;
    }

    /**
     * Hiển thị danh sách nhóm quyền.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->all();
        if (isset($filter['is_active']) && $filter['is_active'] == -1) {
            unset($filter['is_active']);
        }

        $groups = $this->group->getListPagination($filter);

        return view('userandpermission::group.index', [
            'filter' => $groups['filter'],
            'list' => $groups['data'],
        ]);
    }

    /**
     * Hiển thị form tạo nhóm quyền.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_users = $this->user->getListAll()['data']->toArray();
        $list_permissions = Permission::all()->toArray();

        return view('userandpermission::group.create', compact('list_users', 'list_permissions'));
    }

    /**
     * Xử lý lưu thông tin nhóm quyền tạo mới.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GroupRequest $request)
    {
        $data = $request->validated();
        $result = $this->group->create($data);
        $typeSubmit = $request->type_submit ?? 'submit';

        if ($typeSubmit == 'ajax-continue') {
            $redirectTo = route('userandpermission.group.create');
        } elseif ($typeSubmit == 'ajax-quit') {
            $redirectTo = route('userandpermission.group.index');
        } else {
            $redirectTo = route('userandpermission.group.show', ['id' => $result['data']->id]);
        }

        return nRes($redirectTo, $result['message'], $result['status']);
    }

    /**
     * Hiển thị thông tin chi tiết nhóm quyền.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->group->getDetail($id);

        if ($result['status'] == 404) {
            abort(404, __('Not found'));
        }

        $detail = $result['data'];
        $list_users = $detail->users->toArray();
        $list_permissions = $detail->permissions->toArray();

        return view('userandpermission::group.show', compact('detail', 'list_users', 'list_permissions'));
    }

    /**
     * Hiển thị form chi tiết chỉnh sửa thông tin nhóm quyền.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->group->getDetail($id);

        if ($result['status'] == 404 || auth()->user()->cannot('update', $result['data'])) {
            abort(404, __('Not found'));
        }

        $detail = $result['data'];
        $list_users = $result['users'];
        $list_permissions = $result['permissions'];
        $selectAllUsers = $result['users']->filter(function ($user) {
            return $user['selected'];
        })->count() == $list_users->count();
        $selectAllPermissions = $result['permissions']->filter(function ($permission) {
            return $permission['selected'];
        })->count() == $list_permissions->count();

        return view('userandpermission::group.edit', compact(
            'detail',
            'list_users',
            'list_permissions',
            'selectAllUsers',
            'selectAllPermissions'
        ));
    }

    /**
     * Xử lý cập nhật thông tin nhóm quyền.
     *
     * @param  \Modules\UserAndPermission\Http\Requests\GroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GroupRequest $request, $id)
    {
        $data = $request->validated();
        $result = $this->group->update($data, $id);
        $typeSubmit = $request->type_submit ?? 'submit';

        if ($typeSubmit == 'ajax-continue') {
            $redirectTo = route('userandpermission.group.edit', ['id' => $id]);
        } elseif ($typeSubmit == 'ajax-quit') {
            $redirectTo = route('userandpermission.group.index');
        } else {
            $redirectTo = route('userandpermission.group.show', ['id' => $id]);
        }

        return nRes($redirectTo, $result['message'], $result['status']);
    }

    /**
     * Ajax xử lý xóa nhóm quyền.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->group->delete($id);

        return response()->json($result);
    }
}
