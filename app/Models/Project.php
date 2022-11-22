<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'bl_projects';
    protected $fillable = [
        'name',
        'custom_id',
        'total_links',
        'total_unique_clicks',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function users() {
        return $this->hasMany(\App\Models\User::class, 'user_id', 'id');
    }
}
