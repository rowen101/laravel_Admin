<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmMovementhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_movementhistory', function (Blueprint $table) {
            $table->foreign('warehouse_id', 'FK_wm_movementhistory_wm_warehouse')->references('id')->on('wm_warehouse')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_movementhistory_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('locationfrom_id', 'FK_wm_movementhistory_wm_location')->references('id')->on('wm_location')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('locationto_id', 'FK_wm_movementhistory_wm_location1')->references('id')->on('wm_location')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_movementhistory', function (Blueprint $table) {
            $table->dropForeign('FK_wm_movementhistory_wm_warehouse');
            $table->dropForeign('FK_wm_movementhistory_wm_itemmaster');
            $table->dropForeign('FK_wm_movementhistory_wm_location');
            $table->dropForeign('FK_wm_movementhistory_wm_location1');
        });
    }
}
