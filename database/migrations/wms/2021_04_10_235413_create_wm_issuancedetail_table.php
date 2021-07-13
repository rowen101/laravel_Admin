<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmIssuancedetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_issuancedetail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('issuanceheader_id');
            $table->string('linnum', 20)->nullable();
            $table->integer('itemmaster_id');
            $table->string('description', 100);
            $table->decimal('qtyordered', 18, 8);
            $table->decimal('qtyserved', 18, 8)->default(0);
            $table->string('qtyuom', 20);
            $table->string('lotnumrequired', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_issuancedetail');
    }
}
