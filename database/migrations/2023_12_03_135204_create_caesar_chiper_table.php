<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaesarChiperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caesar_chiper', function (Blueprint $table) {
            $table->string('key', 1);
            $table->string('value', 3);
            $table->index('key');
            $table->unique(['key', 'value']);
            $table->primary(['key', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caesar_chiper');
    }
}
