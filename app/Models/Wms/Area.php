<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends BaseModel
{
    protected $table = "wms_area";
    protected $fillable = [
        'id',
        'uuid',
        'area_code',
        'area_name',
        'area_label',
        'is_active',
        'created_by',
        'updated_by'

    ];
}
