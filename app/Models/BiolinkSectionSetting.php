<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkSectionSetting extends Model
{
    use HasFactory;

    protected $table = 'bl_biolink_section_settings';
    protected $fillable = [
        'link_id', 'section_name', 'status', 'section_position'
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }
}

