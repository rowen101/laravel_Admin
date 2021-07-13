<?php

namespace App\Models\Core;

use App\Base\BaseModel;

class HelpPage extends BaseModel
{
    public function helpSection()
    {
        return $this->belongsTo(HelpSection::class, 'id', 'section_id');
    }
    protected $table = 'help_pages';

    protected $fillable = [
        'id',
        'uuid',
        'section_id',
        'page_name',
        'page_body',
        'is_publish',
        'created_at',
        'updated_at'
    ];
}
