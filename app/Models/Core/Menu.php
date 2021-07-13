<?php

namespace App\Models\Core;

use App\Base\BaseModel;

class Menu extends BaseModel
{
    protected $table = 'core_menu';

    public function coreApp()
    {
        return $this->belongsTo(CoreApp::class, 'id', 'app_id');
    }

    protected $fillable = [
        'id',
        'uuid',
        'app_id',
        'menu_code',
        'menu_title',
        'description',
        'parent_id',
        'menu_icon',
        'menu_route',
        'sort_order',
        'is_active',
        'created_by',
        'update_by'
    ];
}
