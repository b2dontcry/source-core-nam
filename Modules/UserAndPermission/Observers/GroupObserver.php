<?php

namespace Modules\UserAndPermission\Observers;

use Modules\UserAndPermission\Models\Group;
use Modules\UserAndPermission\Models\History;

class GroupObserver
{
    /**
     * Xử lý sự kiện sau khi tạo xong 1 Group.
     *
     * @param  \Modules\GroupAndPermission\Models\Group  $group
     * @return void
     */
    public function created(Group $group)
    {
        $group->saveHistory('create', [
            'ID' => $group->id,
            'Name' => $group->name,
            'Description' => $group->description,
            'Created at' => date('d/m/Y H:i:s', strtotime($group->created_at)),
        ]);
    }

    /**
     * Xử lý sự kiện sau khi cập nhật Group.
     *
     * @param  \Modules\GroupAndPermission\Models\Group  $group
     * @return void
     */
    public function updated(Group $group)
    {
        $group->saveHistory('edit', [
            'ID' => $group->id,
            'Name' => $group->name,
            'Description' => $group->description,
            'Created at' => date('d/m/Y H:i:s', strtotime($group->created_at)),
            'Updated at' => date('d/m/Y H:i:s', strtotime($group->updated_at)),
        ]);
    }

    /**
     * Xử lý sự kiện sau khi xóa Group.
     *
     * @param  \Modules\GroupAndPermission\Models\Group  $group
     * @return void
     */
    public function deleted(Group $group)
    {
        $group->saveHistory('delete');
    }

    /**
     * Xử lý sự kiện sau khi xóa cứng Group.
     *
     * @param  \Modules\GroupAndPermission\Models\Group  $group
     * @return void
     */
    public function forceDeleted(Group $group)
    {
        # code...
    }
}
