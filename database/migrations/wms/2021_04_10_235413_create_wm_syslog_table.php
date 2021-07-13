<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmSyslogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_syslog', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 50)->comment('ERROR, or any identifiable types of log');
            $table->string('module', 50)->comment('name of the module accessed');
            $table->string('deviceid', 50);
            $table->text('details');
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
        Schema::dropIfExists('wm_syslog');
    }
}
