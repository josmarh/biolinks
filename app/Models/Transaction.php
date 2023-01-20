<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'bl_transactions';
    protected $fillable = [
        'link_id',
        'section_id',
        'project_id',
        'order_id',
        'order_type', // donation, product, request
        'fulfilled', // digital
        'status', // successful
        'description', // title of sale link
        'amount',
        'transaction_type', // Sale, refund
        'payment_type', // card || paypal
        'pg_tranx_id',
        'payment_id',
    ];
}
