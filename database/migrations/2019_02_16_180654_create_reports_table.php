<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('content');
            $table->mediumText('answer')->nullable();
            $table->string('ip');
            $table->boolean('state')->default(false);
            $table->timestamp('answerd_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('answer_id')->nullable();
//            $table->unsignedBigInteger('report_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reportables', function (Blueprint $table) {
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('reportable_id');
            $table->string('reportable_type');
        });

        Schema::create('report_stats', function (Blueprint $table) {
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
        Schema::dropIfExists('reports');
        Schema::dropIfExists('reportables');
        Schema::dropIfExists('report_stats');
    }
}
