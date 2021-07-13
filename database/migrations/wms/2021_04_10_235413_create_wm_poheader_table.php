<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmPoheaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_poheader', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ponumber', 20);
            $table->integer('warehouse_id');
            $table->integer('supplier_id');
            $table->string('supname', 100);
            $table->dateTime('podate');
            $table->dateTime('poduedate');
            $table->string('referenceno', 20)->nullable();
            $table->string('remarks', 250)->nullable();
            $table->char('status', 1)->default('O');
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
        Schema::dropIfExists('wm_poheader');
    }
}
