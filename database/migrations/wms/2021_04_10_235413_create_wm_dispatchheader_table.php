<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmDispatchheaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_dispatchheader', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->string('dispatchno', 20);
            $table->dateTime('dispatchdate');
            $table->string('waybillno', 20)->nullable();
            $table->dateTime('waybilldate')->nullable();
            $table->string('truckercode', 20)->nullable();
            $table->string('trucktype', 20)->nullable();
            $table->string('driver', 100)->nullable();
            $table->string('plateno', 20)->nullable();
            $table->string('shipmode', 3)->nullable();
            $table->dateTime('deliverydate')->nullable();
            $table->dateTime('departuredate')->nullable();
            $table->string('route', 20)->nullable();
            $table->decimal('volume', 18, 3)->nullable();
            $table->decimal('weight', 18, 3)->nullable();
            $table->string('documentno', 100)->nullable();
            $table->decimal('amount', 18, 3)->nullable();
            $table->dateTime('loadingstart')->nullable();
            $table->dateTime('loadingfinish')->nullable();
            $table->string('remarks', 250)->nullable();
            $table->string('createdby', 20)->nullable();
            $table->dateTime('createdate')->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('updatedate')->nullable();
            $table->char('status', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_dispatchheader');
    }
}
