<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('settings',function(Blueprint $table){

            $table->increments('id');
            $table->string('data_key',50)->unique();
            $table->string('title',50);
            $table->text('data');
            $table->mediumText('options');
            $table->enum('storage_type',['env','only_db'])->default('only_db');
            $table->string('category',100)->nullable();
            $table->string('hints',200);
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
        //
        Schema::dropIfExists('settings');
    }
}
