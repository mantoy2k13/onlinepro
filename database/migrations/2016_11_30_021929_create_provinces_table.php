<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name_en');
            $table->string('name_ja');

            $table->string('country_code');

            $table->integer('order')->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('provinces', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
