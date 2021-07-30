<?php

namespace Modules\UserAndPermission\Observers;

use Modules\UserAndPermission\Models\History;
use Modules\UserAndPermission\Models\User;

class UserObserver
{
    /**
     * @var \Modules\UserAndPermission\Models\History
     */
    private $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }
    /**
     * Xử lý sự kiện sau khi tạo xong 1 user.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->saveHistory('create', [
            'ID' => $user->id,
            'Username' => $user->username,
            'Email' => $user->email,
            'Name' => $user->name,
            'Created at' => date('d/m/Y H:i:s', strtotime($user->created_at)),
        ]);
    }

    /**
     * Xử lý sự kiện sau khi cập nhật user.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if ($user->wasChanged('password')) {
            $user->saveHistory('change_password');
        } elseif ($user->wasChanged()) {
            $user->saveHistory('edit', [
                'ID' => $user->id,
                'Username' => $user->username,
                'Email' => $user->email,
                'Name' => $user->name,
                'Created at' => date('d/m/Y H:i:s', strtotime($user->created_at)),
                'Updated at' => date('d/m/Y H:i:s', strtotime($user->updated_at)),
            ]);
        }
    }

    /**
     * Xử lý sự kiện sau khi xóa user.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $user->saveHistory('delete');
    }

    /**
     * Xử lý sự kiện sau khi xóa cứng user.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        $user->saveHistory('destroy');
    }

    /**
     * Xử lý sự kiện sau khi khôi phục tài khoản.
     *
     * @param  \Modules\UserAndPermission\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        $user->saveHistory('restore');
    }
}
