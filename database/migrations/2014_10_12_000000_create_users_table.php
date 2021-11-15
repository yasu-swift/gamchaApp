<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');  //名前
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('likeGame')->nullable();  //好きなゲーム
            $table->text('profirle')->nullValue();  //自己PR
            $table->string('avatar')->nullable();  //プロフィール画像
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
}
