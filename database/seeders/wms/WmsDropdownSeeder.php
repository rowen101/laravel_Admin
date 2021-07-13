<?php
namespace Database\Seeders\wms;
use App\Models\Wms\Dropdown;
use Illuminate\Database\Seeder;


class WmsDropdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $filePath = database_path().'/seeders/wms/WmsDropdown.json';
        $str = file_get_contents($filePath);
        $json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true );
        foreach ($json as $value) {
            $rowdata = new Dropdown();
            $rowdata->table_key = $value["tableKey"];
            $rowdata->column_key = $value["columnKey"];
            $rowdata->identity_code = $value["identityCode"];
            $rowdata->description = $value["description"];
            $rowdata->sort_order = $value["sortOrder"];
            $rowdata->trace_code = $value["traceCode"];
            $rowdata->is_active = $value["isActive"];
            $rowdata->created_by = 1;
            $rowdata->save();
        }
    }

}
