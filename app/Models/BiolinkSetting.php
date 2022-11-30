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
    ];

    public function link()
    {
        return $this->belongsTo(\App\Models\ProjectLink::class, 'link_id', 'id');
    }
}
