<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmTrucktypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_trucktype', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('typecode', 20);
            $table->string('description', 50);
            $table->decimal('handlingweight', 18, 8)->nullable()->default(0);
            $table->decimal('handlingvolume', 18, 8)->nullable()->default(0);
            $table->integer('sortorder')->default(0);
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
        Schema::dropIfExists('wm_trucktype');
    }
}
