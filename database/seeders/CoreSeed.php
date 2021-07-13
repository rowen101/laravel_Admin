<?php

namespace Database\Seeders;

use Database\Seeders\core\CoreAppSeeder;
use Database\Seeders\core\CoreDropdownSeeder;
use Database\Seeders\core\CoreMenuSeeder;
use Database\Seeders\core\CorePermissionSeeder;
use Database\Seeders\core\CoreRolePermissionSeeder;
use Database\Seeders\core\CoreRoleSeeder;
use Database\Seeders\core\CoreSettingSeeder;
use Database\Seeders\core\CoreUserSeeder;
use Illuminate\Database\Seeder;

class CoreSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CoreAppSeeder::class,
            CoreDropdownSeeder::class,
            CoreMenuSeeder::class,
            CorePermissionSeeder::class,
            CoreRoleSeeder::class,
            CoreRolePermissionSeeder::class,
            CoreUserSeeder::class,
            CoreSettingSeeder::class
        ]);
    }
}
