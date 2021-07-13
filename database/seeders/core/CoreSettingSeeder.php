<?php

namespace Database\Seeders\core;
use App\Models\Core\Setting;
use Illuminate\Database\Seeder;

class CoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $filePath = database_path(). '/seeders/core/CoreSetting.json';
        $str = file_get_contents($filePath);
        $json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true );
        foreach ($json as $value) {
            $rowdata = new Setting();
            $rowdata->id = $value["id"];
            $rowdata->category = $value["category"];
            $rowdata->category_child = $value["categoryChild"];
            $rowdata->setting_code = $value["settingCode"];
            $rowdata->description = $value["description"];
            $rowdata->prerequisite = $value["prerequisite"];
            $rowdata->input_type = $value["inputType"];
            $rowdata->value = $value["value"];
            $rowdata->created_by = 0;
            $rowdata->save();
        }
    }

}
