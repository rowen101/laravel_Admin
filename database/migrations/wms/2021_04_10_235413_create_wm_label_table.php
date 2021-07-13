<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_label', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->integer('lastmovement_id')->default(0);
            $table->string('labelno', 50)->nullable()->unique('IX_wm_label')->comment('This is typically used Pallet No');
            $table->string('referenceno', 20)->nullable()->comment('Issuance ID when shipping out the batch');
            $table->string('labeltype', 10)->nullable()->default('GI')->comment('GI = used for goods issuance or stock can be allocated, SI = iventory stocks already allocated');
            $table->string('remarks', 50)->nullable();
            $table->tinyInteger('islock')->default(0);
            $table->tinyInteger('isvirtual')->default(1);
            $table->integer('printcount')->default(0);
            $table->tinyInteger('issysdefault')->default(0);
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
        Schema::dropIfExists('wm_label');
    }
}
