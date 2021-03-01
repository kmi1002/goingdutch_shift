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
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nick_name');
            $table->date('birthday')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->string('deleted_reason')->nullable();
            $table->string('lang')->nullable()->default('ko');
        });

        Schema::create('user_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('zipcode');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('district');
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->boolean('actived')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user_socials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider');
            $table->string('provider_id');// 카카오 경우 연결 끊고 다시 접속하면 새로운 id 로 갱신 됨
            $table->text('access_token');
            $table->text('refresh_token')->nullable();// facebook 의 경우 refresh_token 이 없음
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user_bans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason');
            $table->timestamp('expired_at');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason')->nullable();
            $table->string('ip');
            $table->string('agent');
            $table->string('referer', 2048);
            $table->string('device');
            $table->timestamp('created_at');
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::create('stat_user', function (Blueprint $table) {
            $table->string('type');
            $table->date('date');
            $table->unsignedInteger('count');
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
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('user_socials');
        Schema::dropIfExists('user_bans');
        Schema::dropIfExists('user_logs');
        Schema::dropIfExists('stat_user');
    }
}
