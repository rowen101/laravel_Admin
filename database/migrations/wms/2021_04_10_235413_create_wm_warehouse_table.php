<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_warehouse', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('storageclass_id');
            $table->string('code', 20);
            $table->string('description', 50);
            $table->tinyInteger('isactive');
            $table->tinyInteger('isinitialized')->default(0)->comment('When 1, it means that the defaults and settings has been set');
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
        Schema::dropIfExists('wm_warehouse');
    }
}
