<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JvzooProductTransaction extends Model
{
    use HasFactory;

    protected $table = 'jv_product_transactions';
    protected $fillable = [
        'user_id',
        'product_id',
        'transaction_id',
        'transaction_type'
    ];
}
