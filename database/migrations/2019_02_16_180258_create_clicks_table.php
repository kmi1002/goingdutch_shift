<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip');
            $table->string('device');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('clickables', function (Blueprint $table) {
            $table->unsignedBigInteger('click_id');
            $table->unsignedBigInteger('clickable_id');
            $table->string('clickable_type');
        });

        Schema::create('click_stats', function (Blueprint $table) {
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
        Schema::dropIfExists('clicks');
        Schema::dropIfExists('clickables');
        Schema::dropIfExists('click_stats');
    }
}
