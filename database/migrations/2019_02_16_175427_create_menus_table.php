<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->unsignedInteger('priority');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('vendor_id');
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('description')->nullable();
            $table->string('caution')->nullable();
            $table->unsignedInteger('original_price');
            $table->unsignedInteger('discount_price')->default(0);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->boolean('recommend')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('group_id');
        });

        Schema::create('option_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->boolean('active')->default(1);
            $table->unsignedInteger('priority');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('vendor_id');
        });

        Schema::create('option_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->boolean('active')->default(1);
            $table->unsignedInteger('priority');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('group_id');
        });


        Schema::create('option_groupables', function (Blueprint $table) {
            $table->unsignedBigInteger('option_group_id');
            $table->unsignedBigInteger('option_groupable_id');
            $table->string('option_groupable_type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_groups');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('option_groupables');
        Schema::dropIfExists('option_groups');
        Schema::dropIfExists('option_items');
    }
}
