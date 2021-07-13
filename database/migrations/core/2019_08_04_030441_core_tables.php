<?php

use Database\Seeders\core\CoreDatabaseSeeder;
use Database\Seeders\CoreSeed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*  This is OUR Application database table
            It stores the list of apps in our system
        */
        Schema::create('core_app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->nullable();
            $table->string('app_code', 20); // application code
            $table->string('app_name', 150); // name of the application
            $table->text('description'); //Describe the product
            $table->string('app_icon', 150)->nullable(); //application icon
            $table->string('status', 20); //ACTIVE,INACTIVE,MAINTENANCE
            $table->string('status_message', 150);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //OUR System client implementation table
        Schema::create('core_client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->nullable();
            $table->string('client_code', 20); // application code
            $table->string('client_name', 150); // name of the application
            $table->text('description')->nullable(); //Describe the product
            $table->string('logo', 150)->nullable(); //application icon
            $table->tinyInteger('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        /*  core_dropdown table
            This table stores the constants and collective information that will be used accross the system
            This is not a transactional table but a storage for modules to identify values inside a dropdown or selections
        */
        Schema::create('core_dropdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_key', 50); // 1st level filter as basis from the view to be created
            $table->string('column_key', 50); // 2nd level filter normally the column or field
            $table->string('identity_code', 50);
            $table->string('description', 255);
            $table->integer('sort_order')->default(10);
            $table->integer('trace_code')->default(50);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->index(['table_key', 'column_key'], 'wi_tbl_idx_table_column');
            $table->index(['identity_code', 'trace_code'], 'wi_tbl_idx_code_map');
            $table->unique(['table_key', 'column_key', 'identity_code'], 'unique_table_column_code');
            $table->engine = 'InnoDB';
        });

        /* core_setting table
            This table will hold the custom configuration of each module to fit on the customer unique business practice
            This will also hold specialized configuration made by OUR team to manage a certain module distinctly
            All records inside this table has an applied logic embedded on the system
        */
        Schema::create('core_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 100)->index(); //Menu or Global
            $table->string('category_child', 100)->index(); //the value to identify or categorize the scope
            $table->string('setting_code', 50)->index();
            $table->string('description', 200)->index();
            $table->string('prerequisite', 100)->nullable(); // setting is dependent to other setting
            $table->string('input_type', 50); //core_vdd_inputtype
            $table->string('value', 255); // the value of the setting based on the input type
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_menu table
        Schema::create('core_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->nullable();
            $table->integer('app_id')->unsigned();
            $table->foreign('app_id')->references('id')->on('core_app');
            $table->string('menu_code', 20)->default('NONE')->index();
            $table->string('menu_title', 100)->index();
            $table->string('description', 255);
            $table->integer('parent_id')->default(0);
            $table->string('menu_icon', 30)->nullable();
            $table->string('menu_route', 50)->deafault('default')->index()->nullable(); // url
            $table->integer('sort_order')->default(100);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //app menu permission
        Schema::create('core_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->foreign('menu_id')->references('id')->on('core_menu');
            $table->string('permission_code', 50);
            $table->string('description', 150)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_role
        Schema::create('core_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->default('');
            $table->string('role_code', 150);
            $table->string('description', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_rolepermission
        Schema::create('core_rolepermission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('core_role');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('core_permission');
            $table->boolean('is_allowed')->default(true);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_user
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 50)->index()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->date('password_change_date')->nullable();
            $table->string('user_type', 20)->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('core_role');
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->integer('is_change_password')->default(0);
            $table->string('last_ip_address', 255)->nullable();
            $table->string('last_session_id', 255)->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->integer('incorrect_logins')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('language', 5)->default('EN'); //core_vdd_language
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //Pasword resets table
        Schema::create('core_passwordreset', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
            $table->engine = 'InnoDB';
        });

        //adding core_icon table
        Schema::create('core_icon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon_name', 100);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_message table
        Schema::create('core_message', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_type', 255); //SUCCESS,FAILURE,WARNING,SYSERROR
            $table->string('message_code', 50);
            $table->string('message', 255);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //adding core_printer table
        Schema::create('core_printer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50)->index()->nullable();
            $table->string('printer_name', 255);
            $table->string('printer_code', 100)->default('')->unique();
            $table->string('ip_address', 100)->nullable();
            $table->string('printer_port', 50)->nullable();
            $table->string('access_type', 50)->default('SMB'); // core_vdd_accesstype
            $table->string('user_name', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('shell_exec', 255)->nullable();
            $table->integer('sort_order')->default(100);
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        // Schema::create('personal_access_tokens', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->morphs('tokenable');
        //     $table->string('name');
        //     $table->string('token', 64)->unique();
        //     $table->text('abilities')->nullable();
        //     $table->timestamp('last_used_at')->nullable();
        //     $table->timestamps();
        //     $table->engine = 'InnoDB';
        // });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
            $table->engine = 'InnoDB';
        });

        // Run the Core database Seeder
        Artisan::call('db:seed', ['--class' => CoreSeed::class]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop app dependent product tables

        //Drop System Tables
        Schema::dropIfExists('core_dropdown');
        Schema::dropIfExists('core_setting');
        Schema::dropIfExists('core_rolepermisson');
        Schema::dropIfExists('core_menu');
        Schema::dropIfExists('core_menupermission');
        Schema::dropIfExists('core_userrole');
        Schema::dropIfExists('users');
        Schema::dropIfExists('core_role');
        Schema::dropIfExists('core_icon');
        Schema::dropIfExists('core_userpreference');
        Schema::dropIfExists('core_printer');
        Schema::dropIfExists('core_errormessasge');
        Schema::dropIfExists('core_client');
        Schema::dropIfExists('core_app');
        Schema::dropIfExists('core_passwordreset');
        // Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('InnoDB');
    }
}
