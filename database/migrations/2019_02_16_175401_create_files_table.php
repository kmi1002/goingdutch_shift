<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('upload_title');
            $table->string('server_title');
            $table->string('path');
            $table->unsignedInteger('download')->default(0);
            $table->unsignedInteger('size')->default(0);
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('extension')->nullbale();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fileables', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id');
            $table->string('fileable_type');
            $table->unsignedBigInteger('fileable_id');
            $table->timestamps();
        });

        Schema::create('file_stats', function (Blueprint $table) {
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
        Schema::dropIfExists('files');
        Schema::dropIfExists('fileables');
        Schema::dropIfExists('file_stats');
    }
}
