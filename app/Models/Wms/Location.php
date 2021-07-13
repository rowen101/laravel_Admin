<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends BaseModel
{
    protected $table = 'wms_location';

    public function Warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'id', 'id');
    }
    protected $fillable = [
        'id',
        'uuid',
        'warehouse_id',
        'area_id',
        'location_code',
        'trace_code',
        'location_name',
        'location_type',
        'size_code',
        'abc_code',
        'check_digit',
        'capacity',
        'drive_zone',
        'drive_sequence',
        'pick_zone',
        'pick_sequence',
        'is_locked',
        'lock_type',
        'is_fix_item',
        'fix_item_code',
        'is_overflow',
        'is_virtual',
        'is_block_stock',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
