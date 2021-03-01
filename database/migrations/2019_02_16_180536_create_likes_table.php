<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip');
            $table->string('device');
            $table->boolean('type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('likeables', function (Blueprint $table) {
            $table->unsignedBigInteger('like_id');
            $table->unsignedBigInteger('likeable_id');
            $table->string('likeable_type');
        });

        Schema::create('like_stats', function (Blueprint $table) {
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
        Schema::dropIfExists('likes');
        Schema::dropIfExists('likeables');
        Schema::dropIfExists('like_stats');
    }
}
