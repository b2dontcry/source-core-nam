<?php

namespace Modules\UserAndPermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'View user',
                'code' => 'view_user',
                'model' => 'Modules\UserAndPermission\Models\User',
            ],
            [
                'id' => 2,
                'name' => 'Create user',
                'code' => 'create_user',
                'model' => 'Modules\UserAndPermission\Models\User',
            ],
            [
                'id' => 3,
                'name' => 'Edit user',
                'code' => 'edit_user',
                'model' => 'Modules\UserAndPermission\Models\User',
            ],
            [
                'id' => 4,
                'name' => 'Delete user',
                'code' => 'delete_user',
                'model' => 'Modules\UserAndPermission\Models\User',
            ],
            [
                'id' => 5,
                'name' => 'View group permissions',
                'code' => 'view_group',
                'model' => 'Modules\UserAndPermission\Models\Group',
            ],
            [
                'id' => 6,
                'name' => 'Create group permissions',
                'code' => 'create_group',
                'model' => 'Modules\UserAndPermission\Models\Group',
            ],
            [
                'id' => 7,
                'name' => 'Edit group permissions',
                'code' => 'edit_group',
                'model' => 'Modules\UserAndPermission\Models\Group',
            ],
            [
                'id' => 8,
                'name' => 'Delete group permissions',
                'code' => 'delete_group',
                'model' => 'Modules\UserAndPermission\Models\Group',
            ],
        ]);
    }
}
