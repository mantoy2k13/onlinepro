<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTeacherCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('teacher_id');
            $table->bigInteger('category_id');

            $table->timestamps();

            $table->index(['teacher_id']);
            $table->index(['category_id']);
        });

        $this->updateTimestampDefaultValue('teacher_categories', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_categories');
    }
}
