<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_inventory', function (Blueprint $table) {
            $table->foreign('id', 'FK_wm_inventory_wm_inventory')->references('id')->on('wm_inventory')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('location_id', 'FK_wm_inventory_wm_location')->references('id')->on('wm_location')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_inventory_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_inventory', function (Blueprint $table) {
            $table->dropForeign('FK_wm_inventory_wm_inventory');
            $table->dropForeign('FK_wm_inventory_wm_location');
            $table->dropForeign('FK_wm_inventory_wm_itemmaster');
        });
    }
}
