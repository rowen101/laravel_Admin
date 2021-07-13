<?php

namespace App\Providers;

use App\Base\DatabaseManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $file = app_path('Base/SystemFunctions.php');
        if (file_exists($file)) {
            require_once($file);
        }

        $file = app_path('Core/CoreFunctions.php');
        if (file_exists($file)) {
            require_once($file);
        }

        $file = app_path('Wms/WmsFunctions.php');
        if (file_exists($file)) {
            require_once($file);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Run Database Manager
        Schema::defaultStringLength(191);
        DatabaseManager::setupDatabase();
        
    }
}
