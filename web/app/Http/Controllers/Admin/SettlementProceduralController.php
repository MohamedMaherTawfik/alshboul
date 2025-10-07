<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\Settlement;
use App\Models\subrocedural;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettlementProceduralController extends Controller
{
    public function showProcedure(Settlement $settlement)
    {
        $settlement->load('proceduralRedords');
        return view('admin.Settlement.procedure', compact('settlement'));
    }

    // إنشاء إجراء جديد
    public function createProcedure(Settlement $settlement)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.Settlement.createProcedure', compact('settlement', 'lawyers'));
    }

    // تخزين الإجراء
    public function storeProcedure(Request $request, Settlement $settlement)
    {
        $data = $request->except('_token', 'file');
        // إنشاء الإجراء
        $procedural = ProceduralRecord::create([
            'settlement_id' => $settlement->id,
            'date' => $data['date'],
            'action' => $data['action'],
            'note' => $data['note'],
            'type' => $data['type'],
            'user_lawyer_id' => Auth::user()->id,
            'user_id' => $data['user_id'],
        ]);

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
        return redirect()->route('settlements.procedure', $settlement)->with('success', 'تم تسجيل الإجراء بنجاح');
    }

    // إضافة ملف للإجراء
    public function addFile(Request $request, ProceduralRecord $settlement)
    {
        if ($request->hasFile('file_path')) {
            foreach ($request->file('file_path') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $settlement->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم تسجيل الملف بنجاح');
    }

    // عرض الإجراء الفرعي
    public function subProcedure(ProceduralRecord $settlement)
    {
        $settlement->load('subProcedurals');
        return view('admin.Settlement.subProcedure', compact('settlement'));
    }

    // تخزين الإجراء الفرعي
    public function storSubProcedure(Request $request, ProceduralRecord $settlement)
    {
        $data = $request->except('_token', 'file');
        $data['procedural_record_id'] = $settlement->id;
        subrocedural::create($data);
        return redirect()->back()
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }


    public function editProcedure(ProceduralRecord $settlement)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.Settlement.editProcedure', compact('settlement', 'lawyers'));
    }

    public function updateProcedure(Request $request, ProceduralRecord $settlement)
    {
        $data = $request->except('_token');
        $settlement->update($data);
        return redirect()->route('settlements.procedure', $settlement->settlement)->with('success', 'تم تعديل الإجراء بنجاح');
    }

    public function deleteProcedure(ProceduralRecord $settlement)
    {
        $settlement->delete();
        return redirect()->back()->with('success', 'تم حذف الإجراء بنجاح');
    }

    public function deleteFile(ProceduralFile $settlement)
    {
        $settlement->delete();
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح');
    }
}
