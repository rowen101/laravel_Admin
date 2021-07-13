<?php

namespace Database\Seeders\core;

use App\Models\Core\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CoreUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = database_path() . '/seeders/core/CoreUser.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new User();
            $rowdata->id = $value["id"];
            $rowdata->email = $value["email"];
            $rowdata->email_verified_at = $value["email_verified_at"];
            $rowdata->password =Hash::make( $value["password"]);
            $rowdata->password_change_date = $value["passwordChangeDate"];
            $rowdata->user_type = $value["userType"];
            $rowdata->role_id = $value["role_id"];
            $rowdata->name = $value["firstName"].' '.$value["lastName"];
            $rowdata->first_name = $value["firstName"];
            $rowdata->last_name = $value["lastName"];
            $rowdata->is_change_password = $value["isChangePassword"];
            $rowdata->last_ip_address = $value["lastIPAddress"];
            $rowdata->last_session_id = $value["lastSessionid"];
            $rowdata->last_activity = $value["lastActivity"];
            $rowdata->incorrect_logins = $value["incorrectLogins"];
            $rowdata->photo = $value["photo"];
            $rowdata->language = $value["language"];
            $rowdata->is_active = $value["isActive"];
            $rowdata->remember_token = $value["remember_token"];
            $rowdata->created_by = 0;
            $rowdata->save();
        }
    }
}
