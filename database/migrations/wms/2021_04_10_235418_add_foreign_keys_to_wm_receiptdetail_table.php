<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmReceiptdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_receiptdetail', function (Blueprint $table) {
            $table->foreign('receiptheader_id', 'FK_wm_receiptdetail_wm_receiptdetail1')->references('id')->on('wm_receiptheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('itemmaster_id', 'FK_wm_receiptdetail_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_receiptdetail', function (Blueprint $table) {
            $table->dropForeign('FK_wm_receiptdetail_wm_receiptdetail1');
            $table->dropForeign('FK_wm_receiptdetail_wm_itemmaster');
        });
    }
}
