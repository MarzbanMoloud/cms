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

            $table->integer('dashboard')->default('0');

            $table->integer('edit_posts')->default('0');
            $table->integer('del_posts')->default('0');
            $table->integer('create_posts')->default('0');

            $table->integer('edit_pages')->default('0');
            $table->integer('del_pages')->default('0');
            $table->integer('create_pages')->default('0');

            $table->integer('manage_category')->default('0');

            $table->integer('create_user')->default('0');
            $table->integer('manage_user')->default('0');

            $table->integer('promote_user')->default('0');

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
