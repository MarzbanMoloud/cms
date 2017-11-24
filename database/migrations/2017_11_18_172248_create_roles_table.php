<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role');

            $table->integer('edit_other_posts');
            $table->integer('del_other_posts');
            $table->integer('edit_posts');
            $table->integer('del_posts');
            $table->integer('edit_publish_posts');
            $table->integer('del_publish_posts');

            $table->integer('edit_other_pages');
            $table->integer('del_other_pages');
            $table->integer('edit_pages');
            $table->integer('del_pages');
            $table->integer('edit_publish_pages');
            $table->integer('del_publish_pages');

            $table->integer('publish_posts');
            $table->integer('publish_pages');

            $table->integer('manage_category');

            $table->integer('create_user');
            $table->integer('edit_user');
            $table->integer('del_user');
            $table->integer('promote_user');
            $table->integer('list_user');

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
        Schema::dropIfExists('roles');
    }
}
