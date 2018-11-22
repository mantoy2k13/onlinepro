<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatePointLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');
            $table->bigInteger('point_amount');

            $table->string('type')->default('');
            $table->text('description')->default('');

            $table->bigInteger('booking_id')->default(0)->index();
            $table->bigInteger('purchase_log_id')->default(0)->index();

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('point_logs', ['updated_at'], ['created_at']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_logs');
    }
}
