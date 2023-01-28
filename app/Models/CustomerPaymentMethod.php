<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'bl_customer_payment_methods';
    protected $fillable = [
        'user_id',
        'card_number',
        'card_month',
        'card_year',
        'card_cvv'
    ];

    public function user()
    {
        return belongsTo(App\Models\Subscriber::class, 'user_id', 'id');
    }
}
