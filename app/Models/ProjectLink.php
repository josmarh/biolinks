<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLink extends Model
{
    use HasFactory;

    protected $table = 'bl_project_links';
    protected $fillable = [
        'project_id',
        'link_id',
        'type',
        'long_url',
        'total_unique_clicks',
        'total_leads',
        'status',
        'user_id'
    ];

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }

    public function user() 
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
