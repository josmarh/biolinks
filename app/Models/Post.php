<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'bl_posts';
    protected $fillable = [
        'project_id',
        'slug',
        'title',
        'excerpt',
        'post',
        'images',
        'featured_image_style',
        'media',
        'products',
        'courses',
        'published_date',
        'author',
        'categories',
        'payment_setting',
        'published_status'
    ];

    public function project() 
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id', 'custom_id');
    }
}
