<?php

namespace Modules\UserAndPermission\Database\Seeders;

use Illuminate\Database\Seeder;

class UserAndPermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            PermissionTableSeeder::class,
            MenuTableSeeder::class
        ]);
    }
}
