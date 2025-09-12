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
        $data = $request->except('_token');
        // إنشاء الإجراء
        $procedural = ProceduralRecord::create([
            'executive_case_id' => $executiveCase->id ?? null,
            'user_lawyer_id' => auth()->user()->id ?? null,
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'type' => $data['type'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'next_action' => $data['next_action'] ?? null,
            'next_action_date' => $data['next_action_date'] ?? null,
        ]);
        // رفع الملفات
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $procedural->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم إضافة الإجراء الفرعي ورفع الملفات بنجاح');
    }

    public function edit(ProceduralRecord $executiveCase)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.procedural-record.edit', compact('executiveCase', 'lawyers'));
    }
    public function update(Request $request, ProceduralRecord $executiveCase)
    {
        $data = $request->except('_token', 'file_path');
        $data['created_by'] = Auth::user()->name;
        // إنشاء الإجراء
        $executiveCase->update([
            'created_by' => $data['created_by'] ?? null,
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'type' => $data['type'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'next_action' => $data['next_action'] ?? null,
            'next_action_date' => $data['next_action_date'] ?? null,
        ]);
        return redirect()->route('procedural-record.index', ['executiveCase' => $executiveCase->case])->with('success', 'تم تعديل الإجراء بنجاح');
    }

    public function show($id, $case_id = null)
    {
        $proceduralRecord = ProceduralRecord::findOrFail($id);
        return view('admin.procedural-record.show', compact('proceduralRecord', 'case_id'));
    }

    public function actions(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('proceduralRecords');
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.procedural-record.index', compact('executiveCase', 'lawyers'));
    }

    public function destroy(ProceduralRecord $executiveCase)
    {
        $executiveCase->delete();
        return redirect()->back()->with('success', 'تم حذف الإجراء بنجاح');
    }

    public function destroyFile(ProceduralFile $executiveCase)
    {
        $executiveCase->delete();
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
    }
}
