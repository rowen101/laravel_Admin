<?php

namespace Database\Seeders\wms;

use App\Models\Wms\UnitOfMeasure;
use Illuminate\Database\Seeder;

class WmsUnitOfMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path() . '/seeders/wms/WmsUnitOfMeasure.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new UnitOfMeasure();
            $rowdata->id = $value["id"];
            $rowdata->uom_code = $value["uomCode"];
            $rowdata->description = $value["description"];
            $rowdata->created_by = 1;
            $rowdata->save();
        }
    }
}
