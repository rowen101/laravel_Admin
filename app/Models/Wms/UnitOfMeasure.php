<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends BaseModel
{
    protected $table = 'wms_unitofmeasure';
    protected $fillable = [
        'id',
        'uom_code',
        'description',
        'created_by',
        'updated_by',
    ];
}
