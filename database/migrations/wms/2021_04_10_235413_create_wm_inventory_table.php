<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_inventory', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('location_id')->default(0);
            $table->integer('label_id')->default(0)->index('IX_wm_inventory_label');
            $table->integer('receiptdetail_id')->default(0)->index('IX_wm_inventory_rrdetail');
            $table->integer('issuancedetail_id')->default(0)->index('IX_wm_inventory_isdetail');
            $table->integer('itemmaster_id')->comment('From Item Master');
            $table->integer('lastmovement_id')->default(0);
            $table->decimal('quantity', 18, 8)->default(0);
            $table->string('quantityuom', 20);
            $table->dateTime('prioritydate')->index('IX_wm_inventory_priodate');
            $table->dateTime('expirydate');
            $table->dateTime('manufacturingdate')->nullable();
            $table->string('lotnum', 20);
            $table->string('recordsource', 20)->comment('RECEIPT,ADJUSTMENT');
            $table->char('status', 1)->comment('GOOD/DAMAGED/RESTRICTED');
            $table->decimal('quantityposted', 18, 8)->default(0)->comment('use this field for any transaction required to post changes to actual quantity');
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable()->index('IX_wm_inventory');
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_inventory');
    }
}
