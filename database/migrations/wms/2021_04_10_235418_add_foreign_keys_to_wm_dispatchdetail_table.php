<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmDispatchdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_dispatchdetail', function (Blueprint $table) {
            $table->foreign('dispatchheader_id', 'FK_wm_dispatchdetail_wm_dispatchheader')->references('id')->on('wm_dispatchheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_dispatchdetail_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_dispatchdetail', function (Blueprint $table) {
            $table->dropForeign('FK_wm_dispatchdetail_wm_dispatchheader');
            $table->dropForeign('FK_wm_dispatchdetail_wm_itemmaster');
        });
    }
}
