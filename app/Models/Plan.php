<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'bl_plans';
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'unlock_type',
        'monthly_pricing',
        'monthly_price',
        'annual_pricing',
        'annual_price',
        'action',
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
