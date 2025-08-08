<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::getSingleton();
        
        return view('pages.about-us.index', compact('aboutUs'));
    }
}