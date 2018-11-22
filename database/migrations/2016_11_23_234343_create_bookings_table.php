<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('teacher_id')->default(0);

            $table->bigInteger('time_slot_id')->default(0);
            $table->bigInteger('category_id')->default(0);

            $table->text('message');
            $table->string('status');

            $table->bigInteger('payment_log_id')->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('bookings', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
