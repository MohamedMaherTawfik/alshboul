<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\excutiveCasesMain;
use Illuminate\Http\Request;

class MainExecutiveController extends Controller
{
    public function index(excutiveCasesMain $excutiveCasesMain)
    {
        $excutiveCasesMain->load('excutiveCases');
        return view('admin.MainExecutive.index', compact('excutiveCasesMain'));
    }
}