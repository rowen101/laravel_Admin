<?php

namespace App\Models\Wms;
use App\Base\BaseModel;

class Dropdown extends BaseModel {
    protected $table = 'wms_dropdown';

    protected $fillable = [
        'id',
        'table_key',
        'column_key',
        'identity_code',
        'description',
        'sort_order',
        'trace_code',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
