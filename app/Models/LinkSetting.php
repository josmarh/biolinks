<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkSetting extends Model
{
    use HasFactory;

    protected $table = 'bl_link_settings';
    protected $fillable = [
        'link_id',
        'tempurl_schedule',
        'tempurl_start_date',
        'tempurl_end_date',
        'tempurl_click_limit',
        'tempurl_expire_url',
        'protection_password',
        'protection_consent_warning',
        'target_type',
        'target_country',
        'target_device',
        'target_browser_lang',
        'target_os'
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }
}
