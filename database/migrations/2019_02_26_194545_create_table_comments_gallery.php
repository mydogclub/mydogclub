<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommentsGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_gallery', function (Blueprint $table) {
            $table->increments('id');

            $table->text('text');           
            $table->integer('parent_id');

            $table->integer('gallery_id')->unsigned()->default(1);
            $table->foreign('gallery_id')->references('id')->on('galleries');

            $table->integer('user_id')->unsigned()->nullable(1);
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_gallery');
    }
}
