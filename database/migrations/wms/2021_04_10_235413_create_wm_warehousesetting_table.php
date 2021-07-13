<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmWarehousesettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_warehousesetting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->string('groupcode', 20)->comment('The warehouse grouping');
            $table->string('code', 20);
            $table->string('description', 50);
            $table->string('valuedatatype', 20)->default('STRING')->comment('STRING,NUMBER,BOOLEAN');
            $table->string('settingvalue', 50);
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
            $table->index(['warehouse_id', 'groupcode', 'code'], 'IX_wm_warehousesetting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_warehousesetting');
    }
}
