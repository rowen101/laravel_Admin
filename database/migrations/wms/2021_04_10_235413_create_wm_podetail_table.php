<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmPodetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_podetail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('poheader_id');
            $table->integer('itemmaster_id');
            $table->string('description', 100);
            $table->decimal('qtypo', 18, 8);
            $table->decimal('qtyreceived', 18, 8);
            $table->string('qtyuom', 20);
            $table->tinyInteger('isactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_podetail');
    }
}
