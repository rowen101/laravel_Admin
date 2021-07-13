<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmIssuanceheaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_issuanceheader', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('issuanceno', 20);
            $table->integer('warehouse_id');
            $table->integer('customer_id');
            $table->string('issuancetype', 20);
            $table->string('referenceno', 20)->nullable();
            $table->string('documentno', 20)->nullable();
            $table->dateTime('transdate');
            $table->dateTime('duedate');
            $table->string('cusname', 100);
            $table->string('remarks', 250)->nullable();
            $table->char('status', 1)->default('N');
            $table->string('tracecode', 20)->nullable();
            $table->char('recordsource', 1)->default('M')->comment('MANUAL,INTERFACE');
            $table->string('createdby', 20)->nullable();
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
        Schema::dropIfExists('wm_issuanceheader');
    }
}
