<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTeacherPersonalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_personalities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('teacher_id');
            $table->bigInteger('personality_id');

            $table->timestamps();

            $table->index(['teacher_id']);
            $table->index(['personality_id']);
        });

        $this->updateTimestampDefaultValue('teacher_personalities', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_personalities');
    }
}
