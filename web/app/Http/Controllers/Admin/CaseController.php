<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseRequest;
use App\Models\CaseOpponents;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\court_session_date;
use App\Models\Lawyer;
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
        $clients = Client::where('active', 1)->where('seen', 1)->get();
        $users = User::with('client')->where('role', 'user')->where('active', 1)->get();

        $numbers = $case->suggestedCases()->pluck('case_number')->sort()->toArray();

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
            return redirect()
                ->route('casetypes.show', $case->suggestedCases)
                ->with(['success' => 'تم اضافة القضية بنجاح']);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(Cases $case)
    {
        $clients = Client::get();
        return view('admin.cases.edit', compact('case', 'clients'));
    }

    public function update(Request $request, Cases $case)
    {
        $oldType = $case->suggested_case_id;

        $case->update($request->all());

        if ($oldType != $case->suggested_case_id) {
            $numbers = Cases::where('suggested_case_id', $case->suggested_case_id)
                ->pluck('case_number')->sort()->toArray();

            $missing = 1;
            foreach ($numbers as $num) {
                if ($num == $missing) {
                    $missing++;
                } elseif ($num > $missing) {
                    break;
                }
            }

            $case->update(['case_number' => $missing]);

            return redirect()->route('cases.show', $case)
                ->with('success', 'تم تعديل القضية بنجاح، رقم الملف الجديد هو: ' . $missing);
        }

        return redirect()->route('cases.show', $case)
            ->with('success', 'تم تعديل القضية بنجاح، رقم الملف هو: ' . $case->case_number);
    }
    // حذف
    public function destroy(Cases $case)
    {
        $case->delete();
        return redirect()->back()->with('success', 'تم حذف القضية بنجاح');
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
                'created_by' => Auth::user()->name,
                'action' => $validated['facts'] ?? null,
                'note' => $validated['note'] ?? null,
                'type' => 'اجراء',
                'user_id' => $validated['lawyer_id'] ?? null,
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
            $court = court_session_date::create([
                'cases_id' => $case->id,
                'date' => $validated['date'],
                'lawyer_user_id' => $validated['lawyer_id'] ?? null,
                'user_id' => auth()->id(),
                'note' => $validated['note'] ?? null,
                'facts' => $validated['facts'] ?? null,
                'type' => 'جلسه',
            ]);

            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $path = $file->store('SessionFiles', 'public');

                    sessionfiles::create([
                        'court_session_date_id' => $court->id,
                        'file' => $path,
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

    public function settlement(Cases $case)
    {
        return view('admin.cases.settlement', compact('case'));
    }

    public function storeSettlement(Request $request, Cases $case)
    {
        $data = $request->except('_token', 'lawsuit_type', 'lawsuit_number');
        $data['cases_id'] = $case->id;
        Settlement::create($data);
        return redirect()->route('cases.all')->with('success', 'تم تسجيل التسوية بنجاح');
    }

    public function expenses(Cases $case)
    {
        $amount = $case->case_amount;
        $benefitDate = $case->benefit_date;

        $years = floor((time() - strtotime($benefitDate)) / (365 * 24 * 60 * 60));

        if ($years > 0) {
            $amount += $case->case_amount * (0.09 * $years);
        }

        return view('admin.cases.expenses', compact('case', 'amount'));
    }


    public function storeExpenses(Request $request, Cases $case)
    {
        return redirect()->route('admin.cases.all')->with('success', 'تم احتساب المصاريف');
    }

    // سجل القضية
    public function log(Cases $case)
    {
        $logs = $case->logs ?? [];
        return view('admin.cases.log', compact('case', 'logs'));
    }

    public function show(Cases $case)
    {
        $case->load([
            'courtSession.sessionFiles',
            'proceduralRedords.files'
        ]);

        // نعمل collection جديدة ونجمع الاتنين
        $sessions = collect();

        foreach ($case->courtSession as $session) {
            $sessions->push([
                'id' => $session->id,
                'date' => $session->date,
                'lawyer' => $session->lawyer_user->name ?? '-',
                'type' => 'جلسة',
                'facts' => $session->facts,
                'note' => $session->note,
                'files' => $session->sessionFiles,
                'user' => $session->user->name
            ]);
        }

        foreach ($case->proceduralRedords as $record) {
            $sessions->push([
                'id' => $record->id,
                'date' => null,
                'lawyer' => $record->user->name ?? '-',
                'type' => $record->type ?? 'إجراء',
                'facts' => $record->action,
                'note' => $record->note,
                'files' => $record->files,
                'user' => $record->created_by
            ]);
        }

        $sessions = $sessions->sortBy('date');

        return view('admin.cases.show', compact('case', 'sessions'));
    }


    public function showDurations(Cases $case)
    {
        $case->load('legalPeriods', );
        return view('admin.cases.caseDurations', compact('case'));
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

        $sessions = court_session_date::with(['cases', 'lawyer'])
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->get();
        $sessionPlucks = court_session_date::with(['cases', 'lawyer'])
            ->whereBetween('date', [$request->date_from, $request->date_to])
            ->pluck('id')->toArray();
        $files = sessionfiles::whereIn('court_session_date_id', $sessionPlucks)->get();
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
            'type' => 'جلسه'
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
            'created_by' => Auth::user()->name,
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
        $request->validate([
            'files' => 'required',
            'files.*' => 'mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

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

        $data['type'] = 'اجراء';
        $case->update($data);
        return redirect()->route('cases.show', $case->cases)
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }

    public function deleteSessionFile(sessionfiles $session)
    {
        $session->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الملف بنجاح');
    }
    public function deleteProcedure(ProceduralRecord $case)
    {
        $case->delete();
        return redirect()->back()
            ->with('success', 'تم حذف الاجراء بنجاح');
    }

}
