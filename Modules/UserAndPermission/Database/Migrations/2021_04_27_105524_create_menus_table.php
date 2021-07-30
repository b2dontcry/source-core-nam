<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->string('route')->comment('Danh sách các route. Lưu dạng JSON.');
            $table->string('group_title')->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('level')->default(1);
            $table->integer('order')->default(1)->comment('Thứ tự hiển thị. Nếu cùng thứ tự thì xếp theo tên.');
            $table->tinyInteger('menu_type')->comment('0: sidebar, 1: nav, 2: list, ...');
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
        Schema::dropIfExists('menus');
    }
}
