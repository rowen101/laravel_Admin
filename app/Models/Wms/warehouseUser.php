<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warehouseUser extends BaseModel
{
    protected $table = "wms_userwarehouse";
    protected $fillable = [
        'warehouse_id',
        'uuid',
        'user_id',
        'user_name',
        'is_active',
        'warehouse_name',
        'created_by',
        'updated_by'
    ];
}
