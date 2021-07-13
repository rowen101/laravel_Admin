<?php

namespace Database\Seeders;

use Database\Seeders\wms\WmsDropdownSeeder;
use Database\Seeders\wms\WmsUnitOfMeasureSeeder;
use Illuminate\Database\Seeder;

class WmsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            WmsDropdownSeeder::class,
            WmsUnitOfMeasureSeeder::class
        ]);

    }
}
