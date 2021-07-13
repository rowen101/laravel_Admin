<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmContactinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_contactinfo', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('contactreference_id');
            $table->string('contactname', 100);
            $table->string('address1', 50)->nullable();
            $table->string('address2', 50)->nullable();
            $table->string('town', 50)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('postal', 10)->nullable();
            $table->string('cellphone', 15)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('emailaddress', 50)->nullable();
            $table->string('contacttype', 10)->comment('S=Supplier,C-customer,T=trucker');
            $table->string('route', 20)->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
            $table->index(['contactreference_id', 'contacttype'], 'IX_wm_contactinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_contactinfo');
    }
}
