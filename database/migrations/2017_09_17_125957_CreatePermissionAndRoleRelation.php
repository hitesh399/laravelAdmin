<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAndRoleRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('permissions',function(Blueprint $table){

            $table->increments('id');
            $table->string('name',50)->unique();
            $table->string('title',200);
            $table->string('section',200)->nullable()->default(null);
            $table->string('prefix',200)->nullable()->default(null);
            $table->string('description',800);

        });

        Schema::create('role_permission',function(Blueprint $table){

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->primary(['role_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_permission');

        Schema::enableForeignKeyConstraints();
    }
}
