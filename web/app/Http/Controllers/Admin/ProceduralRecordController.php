<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProceduralRecord;
use App\Models\ExecutiveCase;
use Illuminate\Http\Request;

class ProceduralRecordController extends Controller
{
    public function index($case_id = null)
    {
        if ($case_id) {
            $executiveCase = ExecutiveCase::findOrFail($case_id);
            return view('admin.procedural-record.index', compact('case_id', 'executiveCase'));
        }
        
        return view('admin.procedural-record.index', compact('case_id'));
    }

    public function create($case_id = null)
    {
        if ($case_id) {
            $executiveCase = ExecutiveCase::findOrFail($case_id);
            return view('admin.procedural-record.create', compact('case_id', 'executiveCase'));
        }
        
        return view('admin.procedural-record.create', compact('case_id'));
    }

    public function edit($id)
    {
        $proceduralRecord = ProceduralRecord::findOrFail($id);
        return view('admin.procedural-record.edit', compact('proceduralRecord'));
    }

    public function show($id, $case_id = null)
    {
        $proceduralRecord = ProceduralRecord::findOrFail($id);
        return view('admin.procedural-record.show', compact('proceduralRecord', 'case_id'));
    }
} 