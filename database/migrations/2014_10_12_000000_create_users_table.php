<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('');
            $table->string('email');
            $table->string('password', 60);

            $table->bigInteger('points')->default(0);

            $table->string('skype_id')->default('');

            $table->integer('year_of_birth')->nullable();
            $table->string('gender')->default('');
            $table->string('living_country_code')->default('');
            $table->bigInteger('living_city_id')->default(0);

            $table->string('locale')->default('');

            $table->bigInteger('last_notification_id')->default(0);

            $table->bigInteger('profile_image_id')->default(0);
            $table->boolean('status')->default(0);
            $table->string('validation_code')->nullable();

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('users', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
