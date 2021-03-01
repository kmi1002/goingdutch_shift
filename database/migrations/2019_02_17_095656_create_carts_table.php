<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 결제
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('session_id');
            $table->string('ip');
            $table->string('device');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('option_1')->nullable();
            $table->unsignedBigInteger('option_2')->nullable();
            $table->unsignedBigInteger('option_3')->nullable();
            $table->unsignedBigInteger('option_4')->nullable();
            $table->unsignedBigInteger('option_5')->nullable();
            $table->unsignedBigInteger('option_6')->nullable();
            $table->unsignedBigInteger('option_7')->nullable();
            $table->unsignedBigInteger('option_8')->nullable();
            $table->unsignedBigInteger('option_9')->nullable();
            $table->unsignedBigInteger('option_10')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
