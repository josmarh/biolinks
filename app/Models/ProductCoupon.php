<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCoupon extends Model
{
    use HasFactory;

    protected $table = 'bl_product_coupons';
    protected $fillable = [
        'project_id',
        'coupon_code',
        'apply_to',
        'discount',
        'coupon_limit_type',
        'coupon_limited_count',
        'limit_per_customer',
        'is_expires',
        'expiry_date'
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
