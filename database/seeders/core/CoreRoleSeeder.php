<?php

namespace Database\Seeders\core;
use App\Models\Core\Role;
use Illuminate\Database\Seeder;

class CoreRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $filePath = database_path(). '/seeders/core/CoreRole.json';
        $str = file_get_contents($filePath);
        $json = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true );
        foreach ($json as $value) {
            $rowdata = new Role();
            $rowdata->id = $value["id"];
            $rowdata->role_code = $value["roleCode"];
            $rowdata->description = $value["description"];
            $rowdata->is_active = $value["isActive"];
            $rowdata->created_by = 0;
            $rowdata->save();
        }
    }

}
