<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseRequest;
use App\Models\CaseNotes;
use App\Models\CaseOpponents;
use App\Models\caseRecords;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\court_session_date;
use App\Models\expenses;
use App\Models\LegalPeriods;
use App\Models\Missions;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\sessionfiles;
use App\Models\Settlement;
use App\Models\subrocedural;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CaseController extends Controller
{
    public function allCases()
    {
        $caseTypes = CaseType::with('suggestedCases')->get();
        $unfinishedMissions = Missions::where('is_done', 0)->count();
        return view('admin.CaseTypes.allCases', compact('caseTypes', 'unfinishedMissions'));
    }

    public function createCase(CaseType $case)
    {
        $clients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
        $users = User::with('client')->where('role', 'user')->where('active', 1)->get();

        $numbers = $case->suggestedCases()->where('active', 1)->where('case_number', '!=', '')->pluck('case_number')->sort()->toArray();

        $missing = 1;
        foreach ($numbers as $num) {
            if ($num == $missing) {
                $missing++;
            } elseif ($num > $missing) {
                break;
            }
        }
        return view('admin.CaseTypes.createCase', compact('case', 'clients', 'users', 'missing'));
    }

    public function storeCase(CaseRequest $request, CaseType $caseType)
    {
        try {
            $data = $request->validated();
            $case = cases::create([
                'client_id' => $data['client_id'] ?? '',
                'subscriber_id' => $data['subscriber_id'] ?? '',
                'first_national_id' => $data['first_national_id'] ?? '',
                'second_national_id' => $data['second_national_id'] ?? '',
                'third_national_id' => $data['third_national_id'] ?? '',
                'suggested_case_id' => $data['suggested_case_id'] ?? '',
                'case_type' => $data['case_type'] ?? '',
                'case_number' => $data['case_number'] ?? '',
                'court_name' => $data['court_name'] ?? '',
                'case_amount' => $data['case_amount'] ?? '',
                'benefit_date' => $data['benefit_date'] ?? '',
                'jubge_name' => $data['jubge_name'] ?? '',
                'case_details' => $data['case_details'] ?? '',
                'client_description' => $data['client_description'] ?? '',
                'general_information' => $data['general_information'] ?? '',
                'private_information' => $data['private_information'] ?? '',
                'file_number' => $data['file_number'] ?? '',
                'added_by_id' => auth()->id(),
            ]);
            foreach ($data['opponent_name'] as $index => $name) {
                CaseOpponents::create([
                    'cases_id' => $case->id,
                    'user_id' => auth()->id(),
                    'case_opponent_name' => $name ?? '',
                    'case_opponent_national_number' => $data['opponent_national_id'][$index] ?? '',
                    'case_opponent_description' => $data['opponent_description'][$index] ?? '',
                ]);
            }
            caseRecords::create([
                'user_id' => Auth::user()->id,
                'cases_id' => $case->id,
                'type' => 'createCase',
            ]);
            return redirect()
                ->route('casetypes.show', $case->suggestedCases)
                ->with(['success' => 'تم اضافة القضية بنجاح']);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(Cases $case)
    {
        $clients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
        $users = User::with('client')->where('role', 'user')->where('active', 1)->get();
        $caseTypes = CaseType::all();
        return view('admin.cases.edit', compact('case', 'clients', 'users', 'caseTypes'));
    }
    public function update(Request $request, Cases $case)
    {
        try {
            $data = $request->except('_token');

            caseRecords::create([
                'user_id' => Auth::user()->id,
                'cases_id' => $case->id,
                'type' => 'تم تعديل القضية بواسطه',
            ]);
            $oldSuggestedId = $case->suggested_case_id;

            if ($oldSuggestedId != $data['suggested_case_id']) {
                $numbers = Cases::where('suggested_case_id', $data['suggested_case_id'])
                    ->pluck('case_number')
                    ->sort()
                    ->toArray();

                $missing = 1;
                foreach ($numbers as $num) {
                    if ($num == $missing) {
                        $missing++;
                    } elseif ($num > $missing) {
                        break;
                    }
                }

                $newCaseNumber = $missing;
            } else {
                // لو ما تغيرتش نحافظ على الرقم القديم
                $newCaseNumber = $case->case_number;
            }

            // نعمل تحديث للقضية
            $case->update([
                'client_id' => $data['client_id'] ?? '',
                'subscriber_id' => $data['subscriber_id'] ?? null,
                'first_national_id' => $data['first_national_id'] ?? '',
                'second_national_id' => $data['second_national_id'] ?? '',
                'third_national_id' => $data['third_national_id'] ?? '',
                'suggested_case_id' => $data['suggested_case_id'] ?? '',
                'case_type' => $data['case_type'] ?? '',
                'case_number' => $newCaseNumber, // الرقم الجديد أو القديم حسب الحالة
                'court_name' => $data['court_name'] ?? '',
                'case_amount' => $data['case_amount'] ?? '',
                'benefit_date' => $data['benefit_date'] ?? '',
                'jubge_name' => $data['jubge_name'] ?? '',
                'case_details' => $data['case_details'] ?? '',
                'client_description' => $data['client_description'] ?? '',
                'general_information' => $data['general_information'] ?? '',
                'private_information' => $data['private_information'] ?? '',
                'added_by_id' => auth()->id(),
            ]);

            // نحذف الخصوم القدام
            CaseOpponents::where('cases_id', $case->id)->delete();

            // نضيف الخصوم الجدد
            if (!empty($data['opponent_name'])) {
                foreach ($data['opponent_name'] as $index => $name) {
                    CaseOpponents::create([
                        'cases_id' => $case->id,
                        'user_id' => auth()->id(),
                        'case_opponent_name' => $name ?? '',
                        'case_opponent_national_number' => $data['opponent_national_id'][$index] ?? '',
                        'case_opponent_description' => $data['opponent_description'][$index] ?? '',
                    ]);
                }
            }

            return redirect()
                ->route('casetypes.show', $case->suggestedCases)
                ->with([
                    'success' => $oldSuggestedId != $data['suggested_case_id']
                        ? "تم تعديل القضية بنجاح. رقم الملف الجديد هو: {$newCaseNumber}"
                        : "تم تعديل القضية بنجاح."
                ]);

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Cases $case)
    {
        $case->update(['active' => 0]);
        return redirect()->back()->with('success', 'تم حذف القضية بنجاح');
    }

    public function indexDelete()
    {
        $cases = cases::where('active', 0)->get();
        return view('admin.cases.indexDelete', compact('cases'));
    }

    public function restore(Cases $case)
    {
        $case->update(['active' => 1]);
        return redirect()->back()->with('success', 'تم استعادة القضية بنجاح');
    }

    // إضافة بيانات للقضية
    public function add(Cases $case)
    {
        $lawers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.cases.add', compact('case', 'lawers'));
    }

    public function storeAdd(Request $request, Cases $case)
    {

        $validated = $request->except('_token');
        if (empty($validated['date'])) {
            $procedural = ProceduralRecord::create([
                'cases_id' => $case->id,
                'user_lawyer_id' => auth()->id() ?? null,
                'action' => $validated['facts'] ?? null,
                'note' => $validated['note'] ?? null,
                'type' => 'اجراء' ?? null,
                'user_id' => $validated['lawyer_id'] ?? null,
                'created_at' => $validated['created_at'] ?? null,
                'next_action' => $validated['next_action'] ?? null,
                'next_action_date' => $validated['next_action_date'] ?? null
            ]);
            caseRecords::create([
                'cases_id' => $case->id,
                'user_id' => auth()->id(),
                'type' => 'تم انشاء اجراء جديد بواسطه',
            ]);
            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $uploadedFile) {
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
                'cases_id' => $case->id,
                'user_lawyer_id' => auth()->id() ?? null,
                'action' => $validated['facts'] ?? null,
                'note' => $validated['note'] ?? null,
                'type' => 'جلسه' ?? null,
                'date' => $validated['date'] ?? null,
                'user_id' => $validated['lawyer_id'] ?? null,
                'created_at' => $validated['created_at'] ?? null,
                'next_action' => $validated['next_action'] ?? null,
                'next_action_date' => $validated['next_action_date'] ?? null
            ]);
            caseRecords::create([
                'cases_id' => $case->id,
                'user_id' => auth()->id(),
                'type' => 'تم انشاء جلسه جديد بواسطه',
            ]);

            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $uploadedFile) {
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
        return redirect()->route('cases.show', $case)->with('success', 'تمت الإضافة بنجاح');
    }


    public function caseSessions(Cases $case)
    {
        $case->load('courtSession');
        return view('admin.cases.caseSessions', compact('case'));
    }

    public function allSettlements(Cases $case)
    {
        $settlements = Settlement::where('cases_id', $case->id)->get();
        return view('admin.cases.allSettlements', compact('case', 'settlements'));
    }

    public function settlement(Cases $case)
    {
        $settlements = Settlement::whereNull('settlement_main_id')
            ->orderBy('file_number')
            ->pluck('file_number') // نجيب القيم بس
            ->filter() // نتأكد إنها مش null
            ->map(fn($n) => (int) $n) // نحولها لأرقام صحيحة
            ->values(); // نرتبهم بالترتيب الصحيح

        // نحسب أول رقم ناقص
        $missingNumber = null;
        if ($settlements->isNotEmpty()) {
            $max = $settlements->max();
            for ($i = 1; $i <= $max + 1; $i++) {
                if (!$settlements->contains($i)) {
                    $missingNumber = $i;
                    break;
                }
            }
        } else {
            // لو مفيش أي رقم في الداتا، نخلي أول رقم 1
            $missingNumber = 1;
        }

        // ابعت الرقم والبيانات للـ Blade
        return view('admin.cases.settlement', compact('case', 'settlements', 'missingNumber'));
    }


    public function storeSettlement(Request $request, Cases $case)
    {
        $data = $request->except('_token', 'lawsuit_type', 'lawsuit_number');


        caseRecords::create([
            'cases_id' => $case->id,
            'user_id' => auth()->id(),
            'type' => 'تم انشاء تسويه جديده بواسطه',
        ]);
        $data['cases_id'] = $case->id;
        Settlement::create($data);
        return redirect()->route('cases.settlement.all', $case ?? '')->with('success', 'تم تسجيل التسوية بنجاح');
    }

    public function expenses(Cases $case)
    {
        $amount = $case->case_amount;
        $benefitDate = $case->benefit_date;

        $years = floor((time() - strtotime($benefitDate)) / (365 * 24 * 60 * 60));

        if ($years > 0) {
            $amount += $case->case_amount * (0.09 * $years);
        }
        $case->load('expenses');
        return view('admin.cases.expenses', compact('case', 'amount'));
    }


    public function storeExpenses(Request $request, Cases $case)
    {
        $data = $request->except('_token');
        if ($data['type'] == 'صرف') {
            caseRecords::create([
                'cases_id' => $case->id,
                'user_id' => auth()->id(),
                'type' => 'تم انشاء صرف جديد بواسطه',
            ]);
        }
        if ($data['type'] == 'قبض') {
            caseRecords::create([
                'cases_id' => $case->id,
                'user_id' => auth()->id(),
                'type' => 'تم انشاء قبض جديد بواسطه',
            ]);
        }
        $data['cases_id'] = $case->id;
        if (!$data['date']) {
            $data['date'] = now()->format('Y-m-d');
        }
        expenses::create($data);
        return redirect()->back()->with('success', 'تم احتساب المصاريف');
    }

    public function destroyExpense(expenses $case)
    {
        $case->delete();
        return redirect()->back()->with('success', 'تم حذف المصاريف');
    }

    // سجل القضية
    public function log(Cases $case)
    {
        $case->load('caseRecords');
        return view('admin.cases.log', compact('case'));
    }

    public function show(Cases $case)
    {

        $more = 0;
        $case->load([
            'proceduralRedords' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);

        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        $settlements = Settlement::where('cases_id', $case->id)->first();
        if ($settlements) {
            $more = $settlements->id;
            return view('admin.cases.show', compact('case', 'lawyers', 'more', 'settlements'));
        }
        return view('admin.cases.show', compact('case', 'lawyers', 'more', 'settlements'));
    }
    public function showDurations(Cases $case)
    {
        $case->load('legalPeriods', );
        return view('admin.cases.caseDurations', compact('case'));
    }

    public function editDurations(LegalPeriods $case)
    {
        return view('admin.durations.edit', compact('case'));
    }

    public function updateDurations(Request $request, LegalPeriods $case)
    {
        $data = $request->except('_token');
        caseRecords::create([
            'cases_id' => $case->cases_id,
            'user_id' => auth()->id(),
            'type' => 'تم تعديل المدة بواسطه',
        ]);
        $case->update($data);
        return redirect()->route('cases.show.durations', $case->case)->with('success', 'تم التحديث بنجاح');
    }

    public function deleteDurations(LegalPeriods $case)
    {
        caseRecords::create([
            'cases_id' => $case->cases_id,
            'user_id' => auth()->id(),
            'type' => 'تم حذف المدة بواسطه',
        ]);
        $case->delete();
        return redirect()->route('cases.show.durations', $case->case)->with('success', 'تم الحذف بنجاح');
    }

    public function editNotes(CaseNotes $case)
    {
        return view('admin.case_notes.edit', compact('case'));
    }

    public function updateNotes(Request $request, CaseNotes $case)
    {
        $data = $request->except('_token');
        caseRecords::create([
            'cases_id' => $case->cases_id,
            'user_id' => auth()->id(),
            'type' => 'تم تعديل المذكره بواسطه',
        ]);
        $case->update($data);
        return redirect()->route('cases.show.notes', $case->case)->with('success', 'تم التحديث بنجاح');
    }

    public function deleteNotes(CaseNotes $case)
    {
        caseRecords::create([
            'cases_id' => $case->cases_id,
            'user_id' => auth()->id(),
            'type' => 'تم حذف المذكره بواسطه',
        ]);
        $case->delete();
        return redirect()->route('cases.show.notes', $case->case)->with('success', 'تم الحذف بنجاح');
    }

    public function showNotes(Cases $case)
    {
        $case->load('caseNotes', );
        return view('admin.cases.caseNotes', compact('case'));
    }

    public function searchPage()
    {
        return view('admin.cases.search');
    }
    public function search(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $sessions = ProceduralRecord::where('type', 'LIKE', 'جلس%')
            ->with(['cases'])
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->get();
        $sessionPlucks = ProceduralRecord::where('type', 'LIKE', 'جلس%')
            ->with(['cases',])
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->pluck('id')
            ->toArray();

        $files = ProceduralFile::whereIn('procedural_record_id', $sessionPlucks)->get();
        return view('admin.cases.search', compact('sessions', 'files'));
    }

    public function editSession(court_session_date $session)
    {
        $lawers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.cases.editSession', compact('session', 'lawers'));
    }

    public function updateSession(Request $request, court_session_date $session)
    {
        $session->update([
            'date' => $request->date,
            'facts' => $request->facts,
            'note' => $request->note,
            'lawyer_user_id' => $request->user_id,
            'type' => 'جلسه',
            'created_at' => $request->created_at
        ]);
        return redirect()->route('cases.show', $session->cases)->with('success', 'تم تعديل القضية بنجاح');
    }

    public function destroySession(court_session_date $session)
    {
        $session->delete();
        return redirect()->back()->with('success', 'تم حذف القضية بنجاح');
    }

    public function showProcedure(Cases $case)
    {
        $case->load('proceduralRedords');
        return view('admin.cases.showProcedure', compact('case'));
    }

    public function createProcedure(Cases $case)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])
            ->where('active', 1)
            ->get();

        return view('admin.cases.createProcedure', compact('case', 'lawyers'));
    }

    public function storeProcedure(Request $request, Cases $case)
    {
        $data = $request->except('_token', 'file');
        $data['cases_id'] = $case->id;
        $data['created_by'] = Auth::user()->name;
        // إنشاء الإجراء
        $procedural = ProceduralRecord::create([
            'cases_id' => $case->id,
            'user_layer' => Auth::user()->name,
            'action' => $data['action'],
            'note' => $data['note'],
            'type' => $data['type'],
            'user_id' => $data['user_id'],
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

        return redirect()->route('cases.procedure', $case)
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }

    public function addFile(Request $request, ProceduralRecord $case)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $case->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }


        return redirect()->back()
            ->with('success', 'تم رفع الملف بنجاح');
    }

    public function subProcedure(ProceduralRecord $case)
    {
        $case->load('subProcedurals');
        return view('admin.cases.subProcedure', compact('case'));
    }

    public function storSubProcedure(Request $request, ProceduralRecord $case)
    {
        $data = $request->except('_token', 'file');
        $data['procedural_record_id'] = $case->id;
        subrocedural::create($data);
        return redirect()->route('case.procedural.show', $case)
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }
    public function uploadFile(Request $request, court_session_date $case)
    {

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('SessionFiles', 'public');

                sessionfiles::create([
                    'court_session_date_id' => $case->id,
                    'file' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'تم رفع الملفات بنجاح');
    }

    public function editSubProcedure(ProceduralRecord $case)
    {
        $case->load('subProcedurals', 'files');
        return view('admin.cases.editSubProcedure', compact('case'));
    }

    public function updateSubProcedure(Request $request, ProceduralRecord $case)
    {
        $data = $request->except('_token', 'file');
        $case->update($data);
        return redirect()->route('cases.show', $case->cases)
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }

    public function deleteSubProcedure(ProceduralRecord $case)
    {
        $case->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الاجراء بنجاح');
    }

    public function deleteFiles(ProceduralFile $case)
    {
        $case->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الملف بنجاح');
    }

    public function trashedCases($caseTypeId)
    {
        $cases = cases::where('suggested_case_id', $caseTypeId)
            ->whereHas('trahsedDays', function ($query) {
                $query->where('is_seen', 1);
            })
            ->with([
                'trahsedDays' => function ($query) {
                    $query->where('is_seen', 1);
                }
            ])
            ->get();

        return view('admin.cases.trashed', compact('cases'));
    }


    public function editProcedure(ProceduralRecord $case)
    {
        $case->load('files');
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.cases.editProcedure', compact('case', 'lawyers'));
    }

    public function updateProcedure(Request $request, ProceduralRecord $case)
    {
        $data = $request->except('_token', 'file');
        if (!$data['date']) {
            caseRecords::create([
                'cases_id' => $case->cases_id,
                'user_id' => auth()->id(),
                'type' => 'تم تعديل الاجراء بواسطه',
            ]);
        }
        if ($data['date']) {
            caseRecords::create([
                'cases_id' => $case->cases_id,
                'user_id' => auth()->id(),
                'type' => 'تم تعديل الجلسه بواسطه',
            ]);
        }
        $case->update($data);
        return redirect()->route('cases.show', $case->cases)
            ->with('success', 'تم تعديل الاجراء بنجاح');
    }

    public function deleteSessionFile(sessionfiles $session)
    {
        $session->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الملف بنجاح');
    }
    public function deleteProcedure(ProceduralRecord $case)
    {
        if ($case->type == 'اجراء') {
            caseRecords::create([
                'cases_id' => $case->cases_id,
                'user_id' => auth()->id(),
                'type' => 'تم حذف الاجراء بواسطه',
            ]);
        }
        if ($case->type == 'جلسه') {
            caseRecords::create([
                'cases_id' => $case->cases_id,
                'user_id' => auth()->id(),
                'type' => 'تم حذف الجلسه بواسطه',
            ]);
        }
        $case->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الاجراء بنجاح');
    }

}
