<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTeacherServiceAuthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_service_authentications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');

            $table->string('name');
            $table->string('email');

            $table->string('service');
            $table->string('service_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('teacher_service_authentications', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_service_authentications');
    }
}
