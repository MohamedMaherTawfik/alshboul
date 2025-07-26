<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsPageController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('about-us', compact('aboutUs'));
    }
} 