<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ExecutiveCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExecutiveCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = 1)
    {
        return view('admin.ExecutiveCase.index', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id = 1)
    {

        return view('admin.ExecutiveCase.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'subscriber_name' => 'nullable|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'client_national_id' => 'nullable|string|max:255',
            'opponent_name' => 'nullable|string|max:255',
            'opponent_national_id' => 'nullable|string|max:255',
            'office_file_number' => 'nullable|integer',
            'lawsuit_number' => 'nullable|string|max:255',
            'suggested_file_number' => 'nullable|integer',
            'case_status' => 'nullable|in:تنفيذية,منتهية,موقوفة,قضية تنفيذية بإنابة',
            'claim_value' => 'nullable|numeric|min:0',
            'execution_department' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:255',
            'judged_for' => 'nullable|string|max:255',
            'judged_against' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'document_number' => 'nullable|string|max:255',
            'judged_for_role' => 'nullable|string|max:255',
            'judged_against_role' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['created_by'] = Auth::id();
            ExecutiveCase::create($data);

            DB::commit();
            return redirect()->route('executive-case.index')->with('success', 'تم إضافة القضية التنفيذية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ExecutiveCase::with(['creator', 'updater'])->findOrFail($id);
        return view('admin.ExecutiveCase.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ExecutiveCase::findOrFail($id);
        return view('admin.ExecutiveCase.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'subscriber_name' => 'nullable|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'client_national_id' => 'nullable|string|max:255',
            'opponent_name' => 'nullable|string|max:255',
            'opponent_national_id' => 'nullable|string|max:255',
            'office_file_number' => 'nullable|integer',
            'lawsuit_number' => 'nullable|string|max:255',
            'suggested_file_number' => 'nullable|integer',
            'case_status' => 'nullable|in:تنفيذية,منتهية,موقوفة,قضية تنفيذية بإنابة',
            'claim_value' => 'nullable|numeric|min:0',
            'execution_department' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:255',
            'judged_for' => 'nullable|string|max:255',
            'judged_against' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'document_number' => 'nullable|string|max:255',
            'judged_for_role' => 'nullable|string|max:255',
            'judged_against_role' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $executiveCase = ExecutiveCase::findOrFail($id);
            $data = $request->except('_token');
            $data['updated_by'] = Auth::id();

            $executiveCase->update($data);

            DB::commit();
            return redirect()->route('executive-case.index')->with('success', 'تم تعديل القضية التنفيذية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $executiveCase = ExecutiveCase::findOrFail($request->id);

        if (!$executiveCase) {
            return redirect()->back()->with('error', 'عفواً لا توجد بيانات');
        }

        $request->validate([
            'reason' => 'required|string',
        ]);

        $executiveCase->updated_by = Auth::id();
        $executiveCase->delete_reason = $request->reason;
        $executiveCase->save();
        $executiveCase->delete();

        return redirect()->route('executive-case.index')->with('success', 'تم حذف القضية التنفيذية بنجاح');
    }

    /**
     * Display deleted executive cases
     */
    public function indexDelete()
    {
        return view('admin.ExecutiveCase.index-delete');
    }

    /**
     * Restore deleted executive case
     */
    public function restore($id)
    {
        $executiveCase = ExecutiveCase::withTrashed()->find($id);

        if (!$executiveCase) {
            return redirect()->route('executive-case.indexDelete')->with('error', 'عفواً لا توجد بيانات');
        }

        $executiveCase->updated_by = Auth::id();
        $executiveCase->delete_reason = "";
        $executiveCase->save();
        $executiveCase->restore();

        return redirect()->route('executive-case.indexDelete')->with('success', 'تم استرجاع القضية التنفيذية بنجاح');
    }
}
