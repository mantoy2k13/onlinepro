<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->default('');
            $table->string('email');
            $table->string('password', 60);
            $table->boolean('status')->default(1);
            $table->string('skype_id')->default('');

            $table->string('locale')->default('');

            $table->bigInteger('last_notification_id')->default(0);
            $table->bigInteger('profile_image_id')->default(0);

            $table->integer('year_of_birth')->nullable();
            $table->string('gender')->default('');
            $table->string('living_country_code')->default('');
            $table->bigInteger('living_city_id')->default(0);

            $table->date('living_start_date')->nullable();
            $table->text('self_introduction')->default('');
            $table->text('introduction_from_admin')->default('');
            $table->text('hobby')->default('');

            $table->string('nationality_country_code')->default('jp');
            $table->bigInteger('home_province_id')->default(0);
            $table->integer('rating')->default(3);

            $table->text('bank_account_info')->default('');

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('teachers', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
