<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id');
            $table->bigInteger('payment_id')->unique();
            $table->boolean('used')->nullable();
            $table->date('expired_at')->nullable();
            $table->timestamps();
        });

        Schema::create('coupon_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('percent')->default(0);
            $table->integer('validity')->nullable();
            $table->bigInteger('vendor_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('coupon_items');
    }
}
