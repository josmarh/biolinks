<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Language;

class HelperController extends Controller
{
    public function country()
    {
        return Country::all();
    }

    public function language()
    {
        return Language::all();
    }
}
