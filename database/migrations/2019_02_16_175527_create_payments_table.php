<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 결제
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dpt_code')->nullable();
            $table->string('order_no');
            $table->string('today_no')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('address')->nullable();
            $table->string('table_no')->nullable();
            $table->string('item');
            $table->unsignedInteger('count');
            $table->unsignedInteger('price');
            $table->string('currency');
            $table->string('ip');
            $table->string('device');
            $table->string('type')->nullable();
            $table->string('data')->nullable();
            $table->string('status')->nullable();
            $table->string('result')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id')->nullable();
        });

        // 결제 - 상품
        Schema::create('payment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedInteger('price');
            $table->string('option_1')->nullable();
            $table->string('option_2')->nullable();
            $table->string('option_3')->nullable();
            $table->string('option_4')->nullable();
            $table->string('option_5')->nullable();
            $table->string('option_6')->nullable();
            $table->string('option_7')->nullable();
            $table->string('option_8')->nullable();
            $table->string('option_9')->nullable();
            $table->string('option_10')->nullable();
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('menu_id');
        });

        Schema::create('stat_payment', function (Blueprint $table) {
            $table->string('type');
            $table->date('date');
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_items');
        Schema::dropIfExists('stat_payment');
    }
}
