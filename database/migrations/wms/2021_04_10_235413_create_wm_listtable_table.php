<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmListtableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wm_listtable', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('tablekey', 50);
            $table->string('columnkey', 50);
            $table->string('identitycode', 50);
            $table->string('description', 100);
            $table->integer('sortorder')->default(10);
            $table->string('tracecode', 50)->nullable();
            $table->tinyInteger('isactive')->default(1);
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
            $table->index(['tablekey', 'columnkey', 'identitycode'], 'IX_wm_listtable_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wm_listtable');
    }
}
