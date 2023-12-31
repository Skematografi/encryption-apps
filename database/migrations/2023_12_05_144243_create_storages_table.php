<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('unique_filename')->unique();
            $table->string('extension', 10);
            $table->bigInteger('user_id');
            $table->integer('size');
            $table->boolean('status')->default(0);
            $table->string('path');
            $table->string('key')->nullable();
            $table->string('init_vector')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}
