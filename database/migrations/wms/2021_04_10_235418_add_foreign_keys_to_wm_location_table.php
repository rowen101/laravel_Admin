<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_location', function (Blueprint $table) {
            $table->foreign('id', 'FK_wm_location_wm_location')->references('id')->on('wm_location')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('warehouse_id', 'FK_wm_location_wm_warehouse')->references('id')->on('wm_warehouse')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_location', function (Blueprint $table) {
            $table->dropForeign('FK_wm_location_wm_location');
            $table->dropForeign('FK_wm_location_wm_warehouse');
        });
    }
}
