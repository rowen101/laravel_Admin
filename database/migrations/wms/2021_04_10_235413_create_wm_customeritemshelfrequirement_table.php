<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmCustomeritemshelfrequirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_customeritemshelfrequirement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('itemmaster_id');
            $table->integer('customer_id');
            $table->integer('percentfreshness')->default(0);
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
        Schema::dropIfExists('wm_customeritemshelfrequirement');
    }
}
