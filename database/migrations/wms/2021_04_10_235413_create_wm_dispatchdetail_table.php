<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmDispatchdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_dispatchdetail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('dispatchheader_id');
            $table->integer('issuancedetail_id');
            $table->integer('inventory_id')->index('IX_wm_dispatchdetail');
            $table->integer('itemmaster_id');
            $table->string('labelno', 50);
            $table->string('description', 100);
            $table->decimal('qtyserved', 18, 8);
            $table->string('qtyuom', 20);
            $table->string('lotnum', 20)->nullable();
            $table->dateTime('expirydate');
            $table->dateTime('manufacturingdate')->nullable();
            $table->string('inventorystatus', 10);
            $table->string('createdby', 20);
            $table->dateTime('createdate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_dispatchdetail');
    }
}
