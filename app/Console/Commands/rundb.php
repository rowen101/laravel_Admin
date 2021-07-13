<?php

namespace App\Console\Commands;

use App\Base\DatabaseManager;
use Exception;
use Illuminate\Console\Command;

class rundb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check if the database is exist if not then create and run migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            DatabaseManager::setupDatabase();
            return "Migration & seeder run successfully.";
        }catch(Exception $e){
            return $e->getMessage();
        }

    }
}
