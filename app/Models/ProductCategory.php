<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'bl_product_categories';
    protected $fillable = [
        'title', 'slug','products','project_id'
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
