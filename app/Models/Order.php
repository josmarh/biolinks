<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'bl_orders';
    protected $fillable = [
        'email',
        'order_type',
        'fulfilled',
        'status', // successful
        'description',
        'link_id',
        'section_id',
        'project_id',
        'total'
    ];
}
