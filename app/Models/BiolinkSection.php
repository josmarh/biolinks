<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkSection extends Model
{
    use HasFactory;

    protected $table = 'bl_biolink_sections';
    protected $fillable = [
        'link_id',
        'section_id',
        'button_text',
        'button_text_color',
        'button_bg_color',
        'core_section_fields',
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(\App\Models\BiolinkSectionSetting::class, 'section_id', 'id');
    }
}
