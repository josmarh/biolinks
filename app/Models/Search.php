<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'search';
    protected $fillable = [
        'q','latitude', 'longitude', 'raduis', 'user_id', 'next_page_token'
    ];

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function prospect()
    {
        return $this->belongsTo('App\User');
    }
}