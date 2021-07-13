<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_customer', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('cuscode', 20);
            $table->string('cusname', 100)->nullable();
            $table->tinyInteger('leadtime')->default(1);
            $table->integer('stockfreshness')->default(0)->comment('Percent requirement for accepted stock freshness');
            $table->char('status', 1)->default('A')->comment('A=Active,I=InActive,H=OnHold');
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
        Schema::dropIfExists('wm_customer');
    }
}
