<?php

namespace App\Http\Controllers;

use App\Models\CaseType;
use Illuminate\Http\Request;

class ServicesPageController extends Controller
{
    public function index()
    {
        $caseTypes = CaseType::all();
        return view('services', compact('caseTypes'));
    }
} 