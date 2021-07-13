<?php

namespace App\Models\Core;

use App\Base\BaseModel;

class HelpSection extends BaseModel
{
    public function coreApp()
    {
        return $this->belongsTo(CoreApp::class, 'id', 'systemID');
    }



    protected $table = 'help_sections';

    protected $fillable = [
        'id',
        'uuid',
        'systemID',
        'section_name',
        'created_at',
        'updated_at'
    ];
}
