<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmDispatchplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_dispatchplan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('dispatchheader_id');
            $table->integer('issuanceheader_id');
            $table->string('createdby', 20);
            $table->dateTime('createdate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_dispatchplan');
    }
}
