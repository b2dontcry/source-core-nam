<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\UserAndPermission\Helpers\Traits\HasModelSupporter;

class Permission extends Model
{
    use HasModelSupporter;

    protected $primaryKey = 'id';

    /**
     * Lấy danh sách quyền và kiểm tra quyền đã chọn.
     *
     * @param  \Illuminate\Support\Collection|arrayarray  $listUserPermissions
     * @return \Illuminate\Support\Collection
     */
    public function getForEdit($listPermissionsSelected)
    {
        if ($listPermissionsSelected instanceof \Illuminate\Support\Collection) {
            $listPermissionsSelected = $listPermissionsSelected->toArray();
        }

        return $this->getListAndCheckSelected($this, [
            'list' => $listPermissionsSelected,
            'column' => ['id', 'name', 'code'],
        ]);
    }

    /**
     * Lấy danh sách quyền của tài khoản
     *
     * @param  int  $user_id
     * @return array
     */
    public function getPermissionUser($user_id)
    {
        $groupPermissions = DB::table('group_permission as gp')
            ->join('permissions as per', 'per.id', '=', 'gp.permission_id')
            ->whereIn('gp.group_id', function ($query) use ($user_id) {
                $query->from('group_user as gu')
                ->where('gu.user_id', $user_id)
                ->select('gu.group_id');
            })
            ->select('per.code');
        $permissions = DB::table('permission_user as pu')
            ->join('permissions as per', 'per.id', '=', 'pu.permission_id')
            ->where('pu.user_id', $user_id)
            ->select('per.code')
            ->union($groupPermissions)
            ->get();

        return $permissions->pluck('code')->toArray();
    }
}
