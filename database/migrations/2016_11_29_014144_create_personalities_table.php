<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatePersonalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name_en');
            $table->string('name_ja');
            $table->string('name_vi');
            $table->string('name_zh');
            $table->string('name_ru');
            $table->string('name_ko');

            $table->integer('order')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['order']);
        });

        $this->updateTimestampDefaultValue('personalities', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personalities');
    }
}
