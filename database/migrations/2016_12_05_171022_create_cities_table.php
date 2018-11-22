<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name_en');
            $table->string('name_ja');

            $table->string('country_code');

            $table->integer('order')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('cities', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
