<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckerMaster extends BaseModel
{
   protected $table = "wms_trucker";
   protected $fillable = [
        'id',
        'uuid',
        'trucker_code',
        'trucker_name',
        'status',
        'trucker_category',
        'created_by',
        'updated_by',

   ];
}
