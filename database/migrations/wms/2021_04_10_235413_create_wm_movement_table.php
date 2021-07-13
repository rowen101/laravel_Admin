<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_movement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->integer('inventory_id');
            $table->integer('receiptdetail_id')->default(0);
            $table->integer('issuancedetail_id')->default(0);
            $table->integer('transaction_id')->default(0)->comment('receiptdetail_id for PA movementcode, issuancedetail_id for SI movement code');
            $table->integer('picklist_id')->default(0);
            $table->integer('locationto_id');
            $table->integer('labelto_id')->default(0)->comment('will have the batchinventory_id when moving only the inventory which is isbatchmove = 0');
            $table->string('movementcode', 20);
            $table->decimal('moveqty', 18, 3);
            $table->string('moveuom', 20);
            $table->dateTime('moveupdatetime')->nullable();
            $table->dateTime('movedowndatetime')->nullable();
            $table->string('movedby', 50)->nullable();
            $table->char('status', 1)->default('O')->comment('O=Open pending movement, X=cancelled, C=Confirmed moved and Closed');
            $table->string('processingtype', 10)->default('M');
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
            $table->decimal('qtyconfirmed', 18, 3)->nullable()->default(0);
            $table->string('lotconfirmed', 20)->nullable();
            $table->string('lotnum', 20)->nullable();
            $table->dateTime('expirydate')->nullable();
            $table->dateTime('manufacturingdate')->nullable();
            $table->string('inventorystatus', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_movement');
    }
}
