<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateFavoriteTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');
            $table->bigInteger('teacher_id');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('favorite_teachers', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_teachers');
    }
}
