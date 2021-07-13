<?php

namespace App\Models\Wms;

use App\Base\BaseModel;

class Customer extends BaseModel
{
    protected $table = 'wms_customer';

    protected $fillable = [
        'id',
        'customer_code',
        'customer_name',
        'freshness_requirement',
        'freshness_unit',
        'customer_category',
        'status',
        'created_by',
        'updated_by',

    ];
}
