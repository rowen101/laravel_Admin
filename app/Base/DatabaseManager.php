<?php

namespace App\Base;

use App\Models\Core\CoreApp;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Our\Core\Repositories\CoreAppRepository;

class DatabaseManager {
    protected static $appDB;
    protected static $auditDB;
    protected static $appDBConnection;
    protected static $auditDBConnection;
    private static $isDBCreated;

    // Initialize OUR Application Database Requiements
    // This will only run on a non production environment
    public static function setupDatabase() {
        //Dont initialize if production
        if (strtolower(config('app.env')) == 'production' || !isset($_SERVER['HTTP_HOST'])) {
            return;
        }

        self::$appDBConnection = config('database.default');
        self::$appDB = config('database.connections.'.self::$appDBConnection.'.database');
        self::$auditDB = self::$appDB.'_audit';
        self::$auditDBConnection = 'auditsql';

        //Setup the database
        self::createDatabase();
        //run migration
        self::runMigration();
    }

    /* Creating the database for the first time
     *  This is called to save some users time in creating the database
     */
    public static function createDatabase() {
         // MYSQL: App Database Initialization
         if (config('database.connections.'.self::$appDBConnection.'.driver') == 'mysql') {
             self::connectToDatabase(self::$appDBConnection,'INFORMATION_SCHEMA');
             // Check if the application database is usable otherwise set it up
             $result = DB::connection(self::$appDBConnection)->select("SELECT SCHEMA_NAME FROM `INFORMATION_SCHEMA`.`SCHEMATA` WHERE SCHEMA_NAME = '".self::$appDB."'");
             // create the application database if it doesn't exists
             if (empty($result)) {
                 self::$isDBCreated = true;
                 $query = 'CREATE DATABASE ' . self::$appDB;
                 DB::connection(self::$appDBConnection)->statement(DB::raw($query));
             }
         }
        //Enabled Auditing
        if (config('audit.enabled') == 'TRUE') {
            // MYSQL: Audit Database Initialization
            if (config('database.connections.'.self::$auditDBConnection.'.driver') == 'mysql') {
                self::connectToDatabase(self::$auditDBConnection,'INFORMATION_SCHEMA');
                //Check if the audit database is usable otherwise set it up
                $result = DB::connection()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".self::$auditDB."'");
                // create the audit database if it doesn't exists
                if (empty($result)) {
                    $query = 'CREATE DATABASE ' . self::$auditDB;
                    DB::connection()->statement(DB::raw($query));
                }
            } elseif (config('database.connections.'.self::$auditDBConnection.'.driver') == 'sqlsrv') {
                self::connectToDatabase(self::$auditDBConnection,'master');
                //Check if the audit database is usable otherwise set it up
                $result = DB::connection(self::$auditDBConnection)->select("SELECT TOP 1 * FROM master.sys.databases WHERE name = '".self::$auditDB."'");
                // create the audit database if it doesn't exists
                if (empty($result)) {
                    $query = 'CREATE DATABASE ' . self::$auditDB;
                    DB::connection(self::$auditDBConnection)->statement(DB::raw($query));
                }
            }

         }
    }

    /* Connecting to database
    * parameter:
     *  $connection : the database connection found in Config database
     *  $dbname : default null but when specified, it will use the database for connection overriding the one defined in the connection attributes
    */
    public static function connectToDatabase($connection,$dbname = null) {
        DB::purge($connection);
        if ($dbname)  {
            Config::set('database.connections.'.  $connection.'.database', $dbname);
        }
        DB::reconnect($connection);
        Schema::connection($connection)->getConnection()->reconnect();
    }

    //Database Migration to create database Objects specified on Migration objects
    public static function runMigration() {
        //Run Audit migration if enabled
        if (config('audit.enabled') == 'TRUE') {
            self::connectToDatabase(self::$auditDBConnection,self::$auditDB);
            Artisan::call('migrate', array('--path' => 'database/migrations/audit', '--force' => true, '--database' => self::$auditDBConnection));
        }

        self::connectToDatabase(self::$appDBConnection,self::$appDB);
        //Calling defaults system database migration
        Artisan::call('migrate');
        Artisan::call('migrate',array('--path' => 'database/migrations/core','--force' => true, '--database' => self::$appDBConnection)); //Core System Tables
        Artisan::call('migrate',array('--path' => 'vendor/laravel/passport/database/migrations','--force' => true, '--database' => self::$appDBConnection)); //OAth Tables
        //Call Oauth default seeder for initial personal access client token
//        if (self::$isDBCreated) {
//            Artisan::call('db:seed', ['--class' => \CoreOauthClientSeeder::class]);
//        }

        //Calling out applications migration from apps table
        $ourApps = new CoreApp();
        foreach ($ourApps->getAllRecords() as $app) {
            if ($app['app_code'] <> 'OUR'){
                // Our appCode should be the same as the directory folder inside migration folder
                Artisan::call('migrate', array('--path' => 'database/migrations/'.strtolower($app['app_code']), '--force' => true, '--database' => self::$appDBConnection));
            }
        }
    }

}
