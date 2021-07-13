## Laravel Admin Starter

Requirements:

-   php 7.4.\* or higher
-   Latest composer
-   Make sure composer is using php 7.4.\* or higher

##### 1. Cloning and install Dependencies via composer

git clone https://github.com/rowen101/laravel_Admin.git ProjectName

checkout main branch

open terminal window inside your cscore directory and type "composer install"

Copy and Rename the following files

1. env.COPYandREMOVEme to .env

##### 2. Add sql login, development host and virtual host in apache

SQL Login  
Username: maldito
Password: balba2018!

##### Go to C:\Windows\System32\drivers\etc\hosts

127.0.0.1 development.ours

##### Go to apache httpd-vhosts.conf file

<VirtualHost *:80>  
  ServerName OursDevelopment  
  ServerAlias *.ours  
  DocumentRoot "D:\Code-Safe\CodeSafeCore\public"  
  <Directory "D:\Code-Safe\CodeSafeCore\public">  
    Options +Indexes +Includes +FollowSymLinks +MultiViews  
    AllowOverride All  
    Require local  
  </Directory>  
</VirtualHost>  

##### 3. Clear cache and Run

terminal type "php artisan config:cache"  
terminal type "composer dump-autoload"

##### Run using wampserver

-   Start wampserver services
-   Browse "http://development.our"

##### Run using artisan

terminal type "php artisan serve --host=development.appname --port=8080"

##### Creating Model via Terminal Window

type: php artisan make:model app/Models/appName/className

##### run Migrations via Terminal Window

type: php artisan migrate --path=/database/migrations/appName

##### run Seeder via Terminal Window

type: php artisan db:seed --class=DatabaseSeederClass

##### Using MSSQL into laravel

-   download requirement for php 7.4 click [here](
https://github.com/microsoft/msphpsql/releases/download/v5.9.0/Windows-7.4.zip)
-   extract Windows-7.4.zip and copy _php_pdo_sqlsrv_74_ts.dll_ , php_sqlsrv_74_ts.dll into `wamp64\bin\php\php7.4.*\ext\`
-   add this code in your php.ini extension both php and apache
    extension=php_sqlsrv_74_ts.dll
    extension=_php_pdo_sqlsrv_74_ts.dll


##### Add this connection parameter in your .env file

DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1  
DB_DATABASE=tms  
DB_USERNAME=sa  
DB_PASSWORD="your password"

#### Using Tinker

-   In your root folder open terminal window type php artisan tinker
-   type project namespace in console window
    eg:
    `namespace AppName\Models`
    `App\Menu::all()`

##### Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

##### Laravel Tutorial from Scratch

https://www.youtube.com/watch?v=EU7PRmCpx-0&list=PLillGF-RfqbYhQsN5WMXy6VsDMKGadrJ-&index=1

##### Audittrail setup

-run command below
composer require owen-it/laravel-auditing

in audit.php under config change the connection according to the database type you need

    'drivers' => [
        'database' => [
            'table'      => 'app_audits',
            'connection' => 'mariaDBAudiTrail', //here you can change mysql, sqlserver, mariadb
        ],
    ],

##### Auditrail MariaDB setup

in config/database.php
'auditrail' => env('DB_AUDITRAILCONNECTION','mariaDBAudiTrail'),
in mysql change the port
'port' => env('DB_PORT', '3307'),
in audit.php under config change the connection according to the database type you need

    'drivers' => [
        'database' => [
            'table'      => 'app_audits',
            'connection' => 'mariaDBAudiTrail', //here you can change mysql, sqlserver, mariadb
        ],
    ],

##### Using Auditrail database connection

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=OURDB
DB_USERNAME=womenandinfants
DB_PASSWORD=milk22
DB_CHARSET=utf8mb4
