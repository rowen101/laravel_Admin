<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_warehouse', function (Blueprint $table) {
            $table->foreign('storageclass_id', 'FK_wm_warehouse_wm_storageclass')->references('id')->on('wm_storageclass')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_warehouse', function (Blueprint $table) {
            $table->dropForeign('FK_wm_warehouse_wm_storageclass');
        });
    }
}
