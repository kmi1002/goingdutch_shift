<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('mobile_title')->nullable();
            $table->string('code');
            $table->string('platform')->nullable();
            $table->string('language')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('parent_id')->nullable();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('content');
            $table->string('link')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('email')->nullable();
            $table->string('homepage')->nullable();
            $table->string('tel')->nullable();
            $table->string('password')->nullable();
            $table->boolean('html')->default(false)->nullable();
            $table->boolean('secret')->default(false)->nullable();
            $table->boolean('notice')->default(false)->nullable();
            $table->boolean('hide_comment')->default(false)->nullable();
            $table->boolean('recevied_email')->default(false)->nullable();
            $table->unsignedInteger('click_cnt')->default(0)->nullable();
            $table->unsignedInteger('like_cnt')->default(0)->nullable();
            $table->unsignedInteger('dislike_cnt')->default(0)->nullable();
            $table->unsignedInteger('comment_cnt')->default(0)->nullable();
            $table->unsignedInteger('share_cnt')->default(0)->nullable();
            $table->unsignedInteger('report_cnt')->default(0)->nullable();
            $table->string('ip');
            $table->string('device');
            $table->string('slug')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
        });

        Schema::create('stat_post', function (Blueprint $table) {
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
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('post_groups');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('stat_post');
    }
}
