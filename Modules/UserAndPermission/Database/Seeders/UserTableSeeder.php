<?php

namespace Modules\UserAndPermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->get()->count() == 0) {
            DB::table('users')->insert([
                [
                    'id' => 1,
                    'name' => 'Administrator',
                    'username' => 'admin',
                    'password' => bcrypt('123456'),
                    'email' => 'admin@example.com',
                    'is_admin' => 1,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
