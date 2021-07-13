<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmIssuancedetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_issuancedetail', function (Blueprint $table) {
            $table->foreign('issuanceheader_id', 'FK_wm_issuancedetail_wm_issuanceheader')->references('id')->on('wm_issuanceheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_issuancedetail_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_issuancedetail', function (Blueprint $table) {
            $table->dropForeign('FK_wm_issuancedetail_wm_issuanceheader');
            $table->dropForeign('FK_wm_issuancedetail_wm_itemmaster');
        });
    }
}
