<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->string('ver');
            $table->string('ip');
            $table->string('agent');
            $table->string('referer', 2048);
            $table->string('device');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('shareables', function (Blueprint $table) {
            $table->unsignedBigInteger('share_id');
            $table->unsignedBigInteger('shareable_id');
            $table->string('shareable_type');
        });

        Schema::create('share_stats', function (Blueprint $table) {
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
        Schema::dropIfExists('shares');
        Schema::dropIfExists('shareables');
        Schema::dropIfExists('share_stats');
    }
}
