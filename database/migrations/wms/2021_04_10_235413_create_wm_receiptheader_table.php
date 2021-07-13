<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmReceiptheaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_receiptheader', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('receiptno', 20);
            $table->integer('warehouse_id');
            $table->dateTime('receiptdate');
            $table->string('receipttype', 20);
            $table->string('referenceno', 20)->nullable();
            $table->string('documentno', 20)->nullable();
            $table->dateTime('documentdate')->nullable();
            $table->integer('supplier_id');
            $table->string('supname', 100)->nullable();
            $table->string('ponumber', 20)->nullable();
            $table->string('deliveryno', 20)->nullable();
            $table->string('trucker', 20)->nullable();
            $table->string('plateno', 20)->nullable();
            $table->string('cvno', 20)->nullable();
            $table->string('driver', 50)->nullable();
            $table->dateTime('arrivaldate')->nullable();
            $table->dateTime('unloadingstart')->nullable();
            $table->dateTime('unloadingfinish')->nullable();
            $table->string('remarks', 250)->nullable();
            $table->char('recordsource', 1)->nullable()->default('M');
            $table->string('tracecode', 20)->nullable();
            $table->char('status', 1)->default('N');
            $table->tinyInteger('ispo')->default(0);
            $table->string('createdby', 20);
            $table->string('updatedby', 20)->nullable();
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
        Schema::dropIfExists('wm_receiptheader');
    }
}
