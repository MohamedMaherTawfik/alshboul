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
        // Get the last active move bar
        $moveBar = MoveBar::where('active', 1)
            ->latest()
            ->first();

        // Get all active sliders
        $sliders = Slider::latest()
            ->get();

        // Get the first about us entry
        $aboutUs = AboutUs::first();

        // Get all active case types
        $caseTypes = CaseType::all();

        return view('welcome', compact('moveBar', 'sliders', 'aboutUs', 'caseTypes'));
    }
}
