<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserServiceAuthenticationUserIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_service_authentications', function (Blueprint $table) {
            $table->string('service_id')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_service_authentications', function (Blueprint $table) {
            $table->bigInteger('service_id')->default(0)->change();
        });
    }
}
