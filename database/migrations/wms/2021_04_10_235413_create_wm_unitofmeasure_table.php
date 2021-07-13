<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmUnitofmeasureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_unitofmeasure', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('shortname', 20);
            $table->string('longname', 50);
            $table->string('uomtype', 20)->comment('this is to identify what if this uom is a form like case/pallet or a measurement to content like kg or ml');
            $table->tinyInteger('isactive');
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_unitofmeasure');
    }
}
