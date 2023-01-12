<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    use HasFactory;

    protected $table = 'bl_project_teams';
    protected $fillable = [
        'project_id', 'user_id', 'status' // 1: active, 2: blocked, 0: removed
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
