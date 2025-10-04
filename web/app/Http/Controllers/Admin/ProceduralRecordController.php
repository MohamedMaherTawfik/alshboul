<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\ExecutiveCase;
use App\Models\Settlement;
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
        $validated = $request->except('_token');
        if (empty($validated['date'])) {
            $procedural = ProceduralRecord::create([
                'executive_case_id' => $executiveCase->id,
                'user_lawyer_id' => auth()->id() ?? null,
                'action' => $validated['action'] ?? null,
                'note' => $validated['note'] ?? null,
                'type' => 'اجراء' ?? null,
                'user_id' => $validated['user_id'] ?? null,
                'created_at' => $validated['created_at'] ?? null,
                'next_action' => $validated['next_action'] ?? null,
                'next_action_date' => $validated['next_action_date'] ?? null
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $uploadedFile) {
                    $path = $uploadedFile->store('ProceduralFiles', 'public');

                    ProceduralFile::create([
                        'procedural_record_id' => $procedural->id,
                        'created_by' => auth()->id(),
                        'file_path' => $path,
                        'updated_by' => auth()->id(),
                    ]);
                }
            }

        } else {
            $procedural = ProceduralRecord::create([
                'executive_case_id' => $executiveCase->id,
                'user_lawyer_id' => auth()->id() ?? null,
                'action' => $validated['action'] ?? null,
                'note' => $validated['note'] ?? null,
                'type' => 'جلسه' ?? null,
                'date' => $validated['date'] ?? null,
                'user_id' => $validated['user_id'] ?? null,
                'created_at' => $validated['created_at'] ?? null,
                'next_action' => $validated['next_action'] ?? null,
                'next_action_date' => $validated['next_action_date'] ?? null
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $uploadedFile) {
                    $path = $uploadedFile->store('ProceduralFiles', 'public');

                    ProceduralFile::create([
                        'procedural_record_id' => $procedural->id,
                        'created_by' => auth()->id(),
                        'file_path' => $path,
                        'updated_by' => auth()->id(),
                    ]);
                }
            }

        }

        return redirect()->route('procedural-record.index', $executiveCase)->with('success', 'تمت الإضافة بنجاح');
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
        $executiveCase->update([
            'action' => $data['action'] ?? null,
            'note' => $data['note'] ?? null,
            'date' => $data['date'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'next_action' => $data['next_action'] ?? null,
            'next_action_date' => $data['next_action_date'] ?? null,
            'created_at' => $data['created_at'] ?? null
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
        $more = 0;
        $settlements = Settlement::where('executive_case_id', $executiveCase->id)->first();
        if ($settlements) {
            $more = $settlements->id;
        }
        $executiveCase->load('proceduralRecords');
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.procedural-record.index', compact('executiveCase', 'lawyers', 'more'));
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
