<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchResults extends Model
{
    use HasFactory;

    protected $table = 'searchresults';
    protected $fillable = [
        'name','description', 'url', 'country', 'city', 'phone','email','place_id','types','ratings',
        'reviews','icon','search_id','created_id','updated_id'
    ];
}
