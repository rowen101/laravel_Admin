<?php

namespace App\Models\Wms;


use App\Base\BaseModel;
class SupplierMaster extends BaseModel
{
    protected $table = 'wms_supplier';

    protected $fillable = [
        'id',
        'uuid',
        'supplier_code',
        'supplier_name',
        'status',
        'supplier_category',
        'created_by',
        'updated_by',

    ];
}
