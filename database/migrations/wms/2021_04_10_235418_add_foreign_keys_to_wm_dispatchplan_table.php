<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWmDispatchplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wm_dispatchplan', function (Blueprint $table) {
            $table->foreign('dispatchheader_id', 'FK_wm_dispatchplan_wm_dispatchheader')->references('id')->on('wm_dispatchheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('issuanceheader_id', 'FK_wm_dispatchplan_wm_issuanceheader')->references('id')->on('wm_issuanceheader')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wm_dispatchplan', function (Blueprint $table) {
            $table->dropForeign('FK_wm_dispatchplan_wm_dispatchheader');
            $table->dropForeign('FK_wm_dispatchplan_wm_issuanceheader');
        });
    }
}
