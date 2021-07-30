<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('table_name');
            $table->string('key');
            $table->text('data')->nullable();
            $table->enum('device', ['Desktop', 'Tablet', 'Mobile', 'Other'])->default('Other');
            $table->string('device_family', 100)->nullable();
            $table->string('device_model', 100)->nullable();
            $table->ipAddress('ip_address');
            $table->string('platform', 100)->nullable();
            $table->string('browser', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
