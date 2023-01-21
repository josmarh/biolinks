<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailProviderIntegration extends Model
{
    use HasFactory;

    protected $table = 'bl_email_provider_integrations';
    protected $fillable = [
        'project_id',
        'mailchimp',
        'getresponse',
        'emailoctopus',
        'converterkit',
        'mailerlite',
    ];
}
