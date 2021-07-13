<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmWarehousesupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_warehousesupplier', function (Blueprint $table) {
            $table->foreign('warehouse_id', 'FK_wm_warehousesupplier_wm_warehouse')->references('id')->on('wm_warehouse')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('supplier_id', 'FK_wm_warehousesupplier_wm_supplier')->references('id')->on('wm_supplier')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_warehousesupplier', function (Blueprint $table) {
            $table->dropForeign('FK_wm_warehousesupplier_wm_warehouse');
            $table->dropForeign('FK_wm_warehousesupplier_wm_supplier');
        });
    }
}
