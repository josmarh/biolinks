<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'bl_visitors';
    protected $fillable = [
        'link_id', 'section_id', 'ip', 'country', 'country_flag', 'city', 'os'
    ];
}
