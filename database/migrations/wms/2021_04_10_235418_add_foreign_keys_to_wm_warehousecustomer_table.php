<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmWarehousecustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_warehousecustomer', function (Blueprint $table) {
            $table->foreign('warehouse_id', 'FK_wm_warehousecustomer_wm_warehouse')->references('id')->on('wm_warehouse')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('customer_id', 'FK_wm_warehousecustomer_wm_customer')->references('id')->on('wm_customer')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_warehousecustomer', function (Blueprint $table) {
            $table->dropForeign('FK_wm_warehousecustomer_wm_warehouse');
            $table->dropForeign('FK_wm_warehousecustomer_wm_customer');
        });
    }
}
