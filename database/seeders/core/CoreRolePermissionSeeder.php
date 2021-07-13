<?php

namespace Database\Seeders\core;
use App\Models\Core\Permission;
use App\Models\Core\RolePermission;
use Illuminate\Database\Seeder;

class CoreRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $rp = new RolePermission();
        $json = Permission::all()->toArray();
        foreach ($json as $value) {
            $datastore =  array('id' => 0,'role_id' => 1,'permission_id' => $value["id"],'is_allowed' => '1','created_by' => 0);
            $rp->store($datastore);
            unset($datastore);
        }
    }

}
