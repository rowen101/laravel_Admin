<?php

namespace Database\Seeders\core;
use App\Models\Core\Permission;
use Illuminate\Database\Seeder;

class CorePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $permission = new \App\Models\Core\Permission();
        $json = \App\Models\Core\Menu::all();
        foreach ($json as $value) {
            $datastore = array(
                array('id' => 0,'menu_id' => $value["id"],'permission_code' => 'insert','description' => 'insert','created_by' => 0),
                array('id' => 0,'menu_id' => $value["id"],'permission_code' => 'delete','description' => 'delete','created_by' => 0),
                array('id' => 0,'menu_id' => $value["id"],'permission_Code' => 'update','description' => 'update','created_by' => 0));
            $permission::insert($datastore);
            unset($datastore);
        }
    }

}
