<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInvite extends Model
{
    use HasFactory;

    protected $table = 'bl_project_invites';
    protected $fillable = [
        'project_id',
        'invitee_name',
        'invitee_email',
        'invite_id',
        'status',
        'invited_by',
    ];

    public function user() 
    {
        return $this->belongsTo(\App\Models\User::class, 'invited_by', 'id');
    }

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
