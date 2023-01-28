<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JvzooProduct extends Model
{
    use HasFactory;

    protected $table = 'jv_products';
    protected $fillable = [
        'product_id', 
        'name',
        'funnel',
    ];
}
