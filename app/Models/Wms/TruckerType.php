<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckerType extends BaseModel
{
    protected $table = "wms_trucker";
    protected $fillable = [
        'id',
        'uuid',
        'trucker_code',
        'trucker_name',
        'trucker_category',
        'status',
        'created_by',
        'updated_by'
    ];
}
