<?php

namespace App\Http\Controllers;

use App\Models\MoveBar;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\CaseType;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $moveBar = MoveBar::where('active', 1)
            ->get();
        $sliders = Slider::get();
        $aboutUs = AboutUs::first();
        $caseTypes = CaseType::all();

        return view('welcome', compact('moveBar', 'sliders', 'aboutUs', 'caseTypes'));
    }
}
