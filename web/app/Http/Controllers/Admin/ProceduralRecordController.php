<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\ProceduralRecord;
use App\Models\ExecutiveCase;
use Illuminate\Http\Request;

class ProceduralRecordController extends Controller
{
    public function index(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('proceduralRecords');
        return view('admin.procedural-record.index', compact('proceduralRecords'));
    }

    public function create(ExecutiveCase $executiveCase)
    {
        $lawyers = Lawyer::all();
        return view('admin.procedural-record.create', compact('executiveCase', 'lawyers'));
    }
    public function store(Request $request, ExecutiveCase $executiveCase)
    {
        $data = $request->except('_token');
        $data['executive_case_id'] = $executiveCase->id;
        $data['created_by'] = auth()->user()->id;
        ProceduralRecord::create($data);
        return redirect()->route('procedural-record.index', $executiveCase)->with('success', 'تم اضافة سجل المحكمة بنجاح');
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

    public function actions(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('proceduralRecords');
        // dd($executiveCase);
        return view('admin.procedural-record.index', compact('executiveCase'));
    }
}