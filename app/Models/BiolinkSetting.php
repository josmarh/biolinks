<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkSetting extends Model
{
    use HasFactory;

    protected $table = 'bl_biolink_settings';
    protected $fillable = [
        'link_id',
        'top_logo',
        'video',
        'title',
        'verified_checkmark',
        'description',
        'background_type',
        'background_type_content',
        'branding',
        'analytics',
        'seo',
        'utm',
        'socials',
        'font',
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }
}
