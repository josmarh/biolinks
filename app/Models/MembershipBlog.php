<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipBlog extends Model
{
    use HasFactory;

    protected $table = 'bl_membership_blogs';
    protected $fillable = [
        'project_id',
        'headline_color',
        'text_color',
        'bg_color',
        'button_color',
        'link_color',
        'post_bg_color',
        'title',
        'sub_heading',
        'disclaimer',
        'header_font_family',
        'text_font_family',
        'posts',
        'subsscriber_alert',
        'subsscriber_alert_color',
        'emailbox',
        'post_gated_content',
        'main_setting',
        'smedia',
    ];

    public function project() 
    {
        return $this->belongsTo(Project::class, 'project_id','custom_id');
    }
}
