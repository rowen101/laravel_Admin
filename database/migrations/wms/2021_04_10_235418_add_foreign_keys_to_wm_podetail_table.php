<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmPodetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_podetail', function (Blueprint $table) {
            $table->foreign('poheader_id', 'FK_wm_podetail_wm_poheader')->references('id')->on('wm_poheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_podetail_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_podetail', function (Blueprint $table) {
            $table->dropForeign('FK_wm_podetail_wm_poheader');
            $table->dropForeign('FK_wm_podetail_wm_itemmaster');
        });
    }
}
