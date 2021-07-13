<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmAbccodepriorityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_abccodepriority', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->integer('itemmaster_id');
            $table->string('abccode', 20);
            $table->integer('sortorder')->default(0);
            $table->tinyInteger('isactive');
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
        Schema::dropIfExists('wm_abccodepriority');
    }
}
