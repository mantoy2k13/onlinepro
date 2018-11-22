<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class EmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->default(0);

            $table->string('new_email')->default('');
            $table->string('old_email')->default('');

            $table->boolean('status')->default(0);
            $table->string('validation_code')->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('email_logs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
}
