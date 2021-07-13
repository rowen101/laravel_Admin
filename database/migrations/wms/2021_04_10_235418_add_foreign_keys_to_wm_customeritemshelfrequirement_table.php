<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmCustomeritemshelfrequirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_customeritemshelfrequirement', function (Blueprint $table) {
            $table->foreign('itemmaster_id', 'FK_wm_customeritemshelfrequirement_wm_itemmaster')->references('id')->on('wm_itemmaster')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('customer_id', 'FK_wm_customeritemshelfrequirement_wm_customer')->references('id')->on('wm_customer')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_customeritemshelfrequirement', function (Blueprint $table) {
            $table->dropForeign('FK_wm_customeritemshelfrequirement_wm_itemmaster');
            $table->dropForeign('FK_wm_customeritemshelfrequirement_wm_customer');
        });
    }
}
