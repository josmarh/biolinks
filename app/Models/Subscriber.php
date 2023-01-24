<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;

class Subscriber extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'subscriber';
    protected $table = 'bl_subscribers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'created_by',
        // 'plan'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
