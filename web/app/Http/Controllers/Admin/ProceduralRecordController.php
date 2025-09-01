<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\ExecutiveCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProceduralRecordController extends Controller
{
    public function index(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('proceduralRecords');
        return view('admin.procedural-record.index', compact('proceduralRecords'));
    }

    public function create(ExecutiveCase $executiveCase)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.procedural-record.create', compact('executiveCase', 'lawyers'));
    }
    public function store(Request $request, ExecutiveCase $executiveCase)
    {
        $data = $request->except('_token', 'file_path');
        $data['cases_id'] = $executiveCase->id;
        $data['created_by'] = Auth::user()->name;
        // إنشاء الإجراء
        $procedural = ProceduralRecord::create([
            'executive_case_id' => $executiveCase->id ?? null,
            'created_by' => $data['created_by'] ?? null,
            'date' => $data['date'] ?? null,
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'type' => $data['type'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'next_action' => $data['next_action'] ?? null,
            'next_action_date' => $data['next_action_date'] ?? null,
        ]);
        // رفع الملفات
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $procedural->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->route('procedural-record.index', $executiveCase)->with('success', 'تم إضافة الإجراء الفرعي ورفع الملفات بنجاح');
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