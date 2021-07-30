<?php

namespace Modules\UserAndPermission\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\UserAndPermission\Helpers\Traits\HasModelSupporter;

class GroupPermission extends Model
{
    use HasModelSupporter;

    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Thêm quyền cho nhóm quyền.
     *
     * @param  array  $data
     * @return void
     */
    public function adds(array $data)
    {
        $this->insert($data);
    }

    /**
     * Xóa quyền khỏi nhóm quyền.
     *
     * @param  int  $group_id
     * @return bool
     */
    public function remove($group_id)
    {
        $history = new History();
        $history->add($this->getTable(), 'delete');

        return $this->where('group_id', $group_id)->delete();
    }
}
