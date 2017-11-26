<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('roles',function(Blueprint $table){

            $table->increments('id');
            $table->string('name',50)->unique();
            $table->string('title',200);
            $table->string('description',800);
            $table->enum('role_for',['backend','frontend'])->default('backend')->comment("Assigned user can access Admin Panel or frontend.");
            $table->string('landing_page',100)->default('');

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
        
        Schema::dropIfExists('roles');
        Schema::enableForeignKeyConstraints();
    }
}
