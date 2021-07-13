<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_location', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->string('loccode', 20)->unique('IX_wm_location');
            $table->string('locationgroup', 20)->default('0')->comment('Reference locationgroup when not 0. This will be used if we are to group location and specify customer specific allowed location group to get allocation like safe pick location role');
            $table->string('locationtype', 20)->comment('BULK,PICK,RESTRICTED,DAMAGE,SHIPPING,RECEIVING,DISCREPANCY');
            $table->string('abccode', 20);
            $table->string('description', 50);
            $table->integer('batchcapacity')->default(1);
            $table->tinyInteger('isactive');
            $table->tinyInteger('islockin')->default(0);
            $table->tinyInteger('islockout')->default(0);
            $table->tinyInteger('isoverflow')->default(0);
            $table->tinyInteger('isvirtual')->default(0)->comment('use to identify if location doesn\'t exists physically');
            $table->string('drivezone', 20)->nullable();
            $table->integer('putawayorder')->default(100);
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
        Schema::dropIfExists('wm_location');
    }
}
