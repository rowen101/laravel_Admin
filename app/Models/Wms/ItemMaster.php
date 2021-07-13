<?php

namespace App\Models\Wms;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMaster extends BaseModel
{
    protected $table = "wms_itemmaster";
    protected $fillable = [
        'id',
        'uuid',
        'storageclass_id',
        'itemcode',
        'referencecode',
        'description',
        'shortdesc',
        'type',
        'handlingunit',
        'abccode',
        'unitcost',
        'safestocklevel',
        'shelflifeunit',
        'salvagedays',
        'stockrestriction',
        'lotformat',
        'lotformatdate',
        'batchfindstrategy',
        'unitqtyperbatch',
        'eachuom',
        'eachqtyperhandlingunit',
        'handlingunitbarcode',
        'eachbarcode',
        'unitcontentuom',
        'unitcontentqty',
        'unitvolume',
        'unitweight',
        'minreplenishmentlvl',
        'maxreplenishmentqty',
        'eachreplenishmentlvl',
        'eachhureplenishmentqty',
        'caselocation',
        'eachlocation',
        'isbatchmanaged',
        'status',
        'createdby',
        'updatedby',
        'createdate',
        'updatedate'
    ];
}
