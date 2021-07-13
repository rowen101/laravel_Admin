<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmPicklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_picklist', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('warehouse_id');
            $table->string('movementcode', 20);
            $table->integer('printcount');
            $table->string('picklisttype', 10)->default('PICKER')->comment('PICKER,CHECKER,TRUCKER');
            $table->string('printnotes', 100)->nullable();
            $table->string('lastprintby', 20)->nullable();
            $table->dateTime('lastprintdate')->nullable();
            $table->string('primaryassignee', 50)->nullable();
            $table->string('secondaryassignee', 50)->nullable();
            $table->string('checker', 50)->nullable();
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
        Schema::dropIfExists('wm_picklist');
    }
}
