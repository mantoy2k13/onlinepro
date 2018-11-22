<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name_ja')->default('');
            $table->string('name_en')->default('');
            $table->string('slug')->default('');

            $table->bigInteger('image_id')->default(0);

            $table->text('description_ja')->default('');
            $table->text('description_en')->default('');

            $table->integer('order')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('lessons', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
