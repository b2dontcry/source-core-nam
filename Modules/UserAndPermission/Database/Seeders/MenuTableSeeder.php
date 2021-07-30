<?php

namespace Modules\UserAndPermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\UserAndPermission\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        DB::table('menus')->insert([
            [
                'id' => 1,
                'name' => 'User and permission',
                'icon' => 'fas fa-users',
                'route' => json_encode([
                    'view_user' => 'userandpermission.user.index',
                    'view_group' => 'userandpermission.group.index',
                ]),
                'group_title' => 'System',
                'parent_id' => 0,
                'level' => 1,
                'order' => 1,
                'menu_type' => Menu::MENU_TYPE_SIDEBAR,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Users list',
                'icon' => 'fas fa-user',
                'route' => json_encode(['view_user' => 'userandpermission.user.index']),
                'group_title' => 'System',
                'parent_id' => 1,
                'level' => 2,
                'order' => 1,
                'menu_type' => Menu::MENU_TYPE_SIDEBAR,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Groups list',
                'icon' => 'fas fa-user-friends',
                'route' => json_encode(['view_group' => 'userandpermission.group.index']),
                'group_title' => 'System',
                'parent_id' => 1,
                'level' => 2,
                'order' => 2,
                'menu_type' => Menu::MENU_TYPE_SIDEBAR,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Histories list',
                'icon' => 'fas fa-history',
                'route' => json_encode(['view_history' => 'userandpermission.history.index']),
                'group_title' => 'System',
                'parent_id' => 0,
                'level' => 1,
                'order' => 2,
                'menu_type' => Menu::MENU_TYPE_SIDEBAR,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
