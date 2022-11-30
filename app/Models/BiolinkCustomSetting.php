<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkCustomSetting extends Model
{
    use HasFactory;

    protected $table = 'bl_biolink_custom_settings';
    protected $fillable = [
        'link_id',
        'header_script',
        'footer_script',
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }
}
