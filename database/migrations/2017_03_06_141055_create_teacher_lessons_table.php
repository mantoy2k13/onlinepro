<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTeacherLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('teacher_id');
            $table->bigInteger('lesson_id');

            $table->timestamps();

            $table->index(['teacher_id']);
            $table->index(['lesson_id']);
        });

        $this->updateTimestampDefaultValue('teacher_lessons', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_lessons');
    }
}
