<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use Illuminate\Http\Request;

class proceduralFilesController extends Controller
{
    public function index(ProceduralRecord $proceduralrecord)
    {
        return view('admin.proceduralFiles.index', compact('proceduralrecord'));
    }
}