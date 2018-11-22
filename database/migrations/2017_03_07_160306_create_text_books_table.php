<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateTextBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_books', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title')->default('');
            $table->string('level')->default('');
            $table->bigInteger('file_id')->default(0);
            $table->text('content')->default('');
            $table->integer('order')->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('text_books', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_books');
    }
}
