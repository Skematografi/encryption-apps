<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnPmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_pmr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('out_standing_po_id');
            $table->date('date_return');
            $table->integer('reception_qty')->nullable();
            $table->string('reception_unit', 50)->nullable();
            $table->integer('rejection_qty')->nullable();
            $table->string('rejection_unit', 50)->nullable();
            $table->integer('example_qty')->nullable();
            $table->string('example_unit', 50)->nullable();
            $table->double('aql', 8, 2);
            $table->string('ac_rc', 10)->nullable();
            $table->text('description')->nullable();
            $table->integer('print')->default(0);
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
        Schema::dropIfExists('return_pmr');
    }
}
