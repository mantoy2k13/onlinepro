<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type')->default(''); // only contact defined at first moment

            $table->unsignedBigInteger('user_id')->default(0);

            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->string('living_country_code')->default('');

            $table->text('content')->default('');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('inquiries', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
}
