<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('username', 150);
            $table->string('password');
            $table->string('email');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_active')->default(true);
            $table->dateTime('latest_login')->nullable();
            $table->enum('mode_check_ip', ['no', 'black_list', 'white_list'])->default('no')
                ->comment('no: không kiểm tra ip khi đăng nhập; black_list: chặn đăng nhập theo danh sách ip; white_list: chỉ cho phép ip trong danh sách được đăng nhập');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
