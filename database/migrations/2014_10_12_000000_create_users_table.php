<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name');
            $table->string('number')->nullable()->comment('工号');
            $table->string('real_name', 50)->nullable()->comment('真实姓名');
            $table->string('email')->unique();
            $table->string('mobile', 20)->nullable()->comment('手机');
            $table->enum('sex', ['男', '女', '保密'])->default('保密')->comment('性别');
            $table->string('avatar')->nullable()->comment('头像');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
};
