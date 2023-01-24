<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLead extends Model
{
    use HasFactory;

    protected $table = 'bl_customer_leads';
    protected $fillable = [
        'email','name','status','orders','lifetime_value','project_id'
    ];

    public function project()
    {
        return $this->belongsTo(App\Models\Project::class, 'project_id','custom_id');
    }
}
