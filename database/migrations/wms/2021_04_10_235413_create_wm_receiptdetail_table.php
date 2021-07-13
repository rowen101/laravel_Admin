<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmReceiptdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_receiptdetail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('receiptheader_id');
            $table->string('linnum', 10)->default('0');
            $table->integer('itemmaster_id');
            $table->string('description', 100);
            $table->decimal('qtyreceived', 18, 8);
            $table->string('qtyuom', 20);
            $table->decimal('qtyconfirmed', 18, 8)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_receiptdetail');
    }
}
