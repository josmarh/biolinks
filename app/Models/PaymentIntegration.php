<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentIntegration extends Model
{
    use HasFactory;

    protected $table = 'bl_payment_integrations';
    protected $fillable = [
        'project_id',
        'stripe_status',
        'stripe_secret',
        'paypal_status',
        'paypal_secret',
        'paypal_client'
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id','custom_id');
    }
}
