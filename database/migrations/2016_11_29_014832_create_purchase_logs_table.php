<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatePurchaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->default(0);

            $table->string('purchase_method_type')->default('');
            $table->bigInteger('point_amount')->default(0);

            $table->timestamp('point_expired_at');
            $table->bigInteger('remaining_point_amount')->default(0);

            $table->text('purchase_info')->default('');
            $table->timestamps();

            $table->index(['user_id', 'point_expired_at', 'created_at']);
            $table->index(['point_expired_at', 'remaining_point_amount']);

        });

        $this->updateTimestampDefaultValue('purchase_logs', ['updated_at'], ['created_at', 'point_expired_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_logs');
    }
}
