<?php

namespace Modules\UserAndPermission\Repositories\Contracts;

interface User extends Repository
{
    /**
     * Xử lý đăng nhập.
     *
     * @param  array  $credentials
     * @return array
     */
    public function handleLogin(array $credentials);
}
