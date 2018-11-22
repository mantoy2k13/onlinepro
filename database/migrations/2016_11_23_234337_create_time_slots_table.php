<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('teacher_id');

            $table->timestamp('start_at');
            $table->timestamp('end_at');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('time_slots', ['updated_at'], ['end_at', 'start_at', 'created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_slots');
    }
}
