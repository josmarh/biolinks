<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\ProjectLink;

class Product extends Model
{
    use HasFactory;

    protected $table = 'bl_products';
    protected $fillable = [
        'project_id',
        'link_id',
        'title',
        'description',
        'category',
        'images',
        'pricing',
        'shipping',
        'inventory',
        'files',
        'external_link',
        'published_status'
    ];

    public function project() 
    {
        return $this->belongsTo(Project::class, 'project_id','custom_id');
    }

    public function link()
    {
        return $this->belongsTo(ProjectLink::class, 'link_id','id');
    }
}
