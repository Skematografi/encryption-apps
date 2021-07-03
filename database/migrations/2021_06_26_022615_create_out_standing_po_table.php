<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutStandingPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_standing_po', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_po', 50);
            $table->date('date_po');
            $table->integer('detail_products_id');
            $table->integer('suppliers_id');
            $table->integer('stock');
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
        Schema::dropIfExists('out_standing_po');
    }
}
