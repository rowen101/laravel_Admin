<?php

namespace App\Models\Core;

use App\Base\BaseModel;

class CoreApp extends BaseModel
{
    protected $table = 'core_app';

    public function menus()
    {
        return $this->hasMany(Menu::class, 'app_id', 'id');
    }
    public function help_sections()
    {
        return $this->hasMany(HelpSection::class, 'systemID', 'id');
    }
    protected $fillable = [
        'id',
        'uuid',
        'app_code',
        'app_name',
        'description',
        'app_icon',
        'status',
        'status_message',
        'created_by',
        'updated_by'
    ];
}
