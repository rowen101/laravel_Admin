<?php

namespace App\Models\Wms;

use App\Base\BaseModel;


class Warehouse extends BaseModel
{
    protected $table = 'wms_warehouse';
    public function Location()
    {
        return $this->hasMany(Location::class, 'id', 'id');
    }
    protected $fillable = [
        'id',
        'uuid',
        'warehouse_code',
        'warehouse_name',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
