<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('target'); // set user or teacher

            $table->bigInteger('user_id');
            $table->bigInteger('teacher_id');
            $table->bigInteger('booking_id');

            $table->integer('rating')->default(0);
            $table->text('content')->default('');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('reviews', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
