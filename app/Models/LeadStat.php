<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStat extends Model
{
    use HasFactory;

    protected $table = 'bl_lead_stats';
    protected $fillable = [
        'email',
        'name',
        'phone',
        'link_id',
        'section_id',
        'user_id',
        'ip'
    ];
}
