<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmMovementhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_movementhistory', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('movement_id')->default(0);
            $table->integer('warehouse_id');
            $table->integer('inventory_id');
            $table->integer('inventoryfrom_id')->default(0);
            $table->integer('receiptdetail_id')->default(0)->index('IX_wm_movementhistory_rrrdtl');
            $table->integer('issuancedetail_id')->default(0)->index('IX_wm_movementhistory_sidtl');
            $table->integer('picklist_id')->default(0);
            $table->integer('transaction_id')->default(0);
            $table->integer('itemmaster_id')->index('IX_wm_movementhistory_item');
            $table->integer('locationfrom_id');
            $table->integer('locationto_id');
            $table->integer('labelfrom_id')->default(0);
            $table->integer('labelto_id')->default(0);
            $table->string('labelnofrom', 50);
            $table->string('labelnoto', 50)->nullable();
            $table->string('movementcode', 20);
            $table->decimal('moveqty', 18, 3)->default(0);
            $table->string('moveuom', 20);
            $table->decimal('moveqtyconfirmed', 18, 3)->default(0);
            $table->string('lotnum', 20);
            $table->string('lotnumconfirmed', 20)->nullable();
            $table->dateTime('expirydate')->nullable();
            $table->dateTime('manufacturingdate')->nullable();
            $table->dateTime('moveupdatetime')->nullable();
            $table->dateTime('movedowndatetime')->nullable();
            $table->string('movedby', 50)->nullable();
            $table->char('inventorystatus', 1);
            $table->string('remarks', 50)->nullable();
            $table->char('status', 1);
            $table->string('processingtype', 10)->default('A')->comment('M=Manually allocated or triggered, A=Automatically created/allocate, AM=Automatic and confirmed mobile, APC automatic confirmed by PC,MM=Manual and confirmed mobile, MPC manual confirmed by PC');
            $table->dateTime('movementcreatedate');
            $table->string('movementcreatedby', 20);
            $table->string('createdby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->index(['warehouse_id', 'movementcode'], 'IX_wm_movementhistory_warmov');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_movementhistory');
    }
}
