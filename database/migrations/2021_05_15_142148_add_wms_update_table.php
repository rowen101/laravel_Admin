<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWmsUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_itemmaster', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('uuid', 50)->index()->default('');
            $table->integer('storageclass_id')->index('IX_wm_itemmaster_storageclass');
            $table->string('itemcode', 20)->unique('IX_wm_itemmaster_itemcode');
            $table->string('referencecode', 20)->nullable();
            $table->string('description', 100);
            $table->string('shortdesc', 30)->nullable();
            $table->string('type', 20)->nullable();
            $table->string('handlingunit', 20);
            $table->string('abccode', 20);
            $table->decimal('unitcost', 18, 8)->default(0);
            $table->decimal('safestocklevel', 18, 8);
            $table->integer('shelflife');
            $table->char('shelflifeunit', 1)->default('D')->comment('M=Months,D=Days');
            $table->integer('salvagedays')->default(1);
            $table->char('stockrestriction', 1)->default('M')->comment('Restriction storage restriction by D-DAY/M-MONTH/P-PRODUCT');
            $table->string('lotformat', 20)->default('YYMMDD');
            $table->char('lotformatdate', 1)->default('E')->comment('E-Expiry,M-Manufacturing');
            $table->string('batchfindstrategy', 10)->default('FEFO')->comment('Batch finding strategy default First Expiry First Out');
            $table->integer('unitqtyperbatch')->default(1);
            $table->string('eachuom', 20);
            $table->integer('eachqtyperhandlingunit');
            $table->string('handlingunitbarcode', 20)->nullable();
            $table->string('eachbarcode', 20)->nullable();
            $table->string('unitcontentuom', 20)->nullable();
            $table->integer('unitcontentqty')->nullable();
            $table->decimal('unitvolume', 18, 8)->default(0)->comment('L x W x H');
            $table->decimal('unitweight', 18, 8)->default(0);
            $table->integer('minreplenishmentlvl')->default(0);
            $table->integer('maxreplenishmentqty')->default(0);
            $table->integer('eachreplenishmentlvl')->default(0);
            $table->integer('eachhureplenishmentqty')->default(0);
            $table->string('caselocation', 20)->nullable();
            $table->string('eachlocation', 20)->nullable();
            $table->tinyInteger('isbatchmanaged')->default(1)->comment('flag to identify if the item is managed through lot number');
            $table->char('status', 1)->default('A');
            $table->string('createdby', 20)->nullable();
            $table->string('updatedby', 20)->nullable();
            $table->dateTime('createdate')->useCurrent();
            $table->dateTime('updatedate')->nullable();
        });

        Schema::table('wms_unitofmeasure', function ($table) {
            $table->string('uuid', 50)->index()->default('');
        });

        Schema::table('wms_userwarehouse', function ($table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
