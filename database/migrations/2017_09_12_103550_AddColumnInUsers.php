<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('user_name',10)->unique()->nullable()->after('email');
            $table->string('mobile_no',15)->unique()->nullable()->after('email');
            $table->enum('is_mobile_no_verified',['N','Y'])->default('N')->after('password');
            $table->enum('is_email_verified',['N','Y'])->default('N')->after('is_mobile_no_verified');
            $table->string('email_verification_token',50)->nullable()->after('is_email_verified');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //

            $table->dropColumn('mobile_no');
            $table->dropColumn('user_name');
            $table->dropColumn('is_mobile_no_verified');
            $table->dropColumn('is_email_verified');
            $table->dropColumn('email_verification_token');
        });
    }
}
