<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('channel');
            $table->string('gender');
            $table->string('age');
            $table->string('name');
            $table->string('title');
            $table->string('content');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('message_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('success');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('user_id');
        });

        Schema::create('stat_message', function (Blueprint $table) {
            $table->string('type');
            $table->date('date');
            $table->string('string');
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
        Schema::dropIfExists('messages');
        Schema::dropIfExists('message_logs');
        Schema::dropIfExists('stat_message');
    }
}
