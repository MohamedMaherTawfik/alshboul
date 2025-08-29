<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseRequest;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\court_session_date;
use App\Models\Lawyer;
use App\Models\Missions;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;

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
        $clients = Client::get();
        $users = User::with('client')->where('role', 'user')->get();

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


    public function storeCase(CaseRequest $request, CaseType $case)
    {
        $data = $request->validated();
        $data['added_by_id'] = auth()->user()->id;
        cases::create($data);
        return redirect()->route('casetypes.show', $case)->with(['success' => 'تم اضافة القضية بنجاح']);

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
        return redirect()->route('cases.all')->with('success', 'تم حذف القضية بنجاح');
    }

    // إضافة بيانات للقضية
    public function add(Cases $case)
    {
        $lawers = Lawyer::get();
        return view('admin.cases.add', compact('case', 'lawers'));
    }

    public function storeAdd(Request $request, Cases $case)
    {
        $validated = $request->except('_token');
        $validated['cases_id'] = $case->id;
        $validated['user_id'] = auth()->user()->id;
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('CourtSessions', 'public');
        }
        court_session_date::create($validated);
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
        $case->load('courtSession', 'caseNotes', 'legalPeriods');
        return view('admin.cases.show', compact('case'));
    }

    public function searchPage()
    {
        return view('admin.cases.search');
    }
    public function search(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $sessions = court_session_date::with('cases')
            ->whereDate('date', $request->date)
            ->get();


        return view('admin.cases.search', compact('sessions'));
    }

    public function editSession(court_session_date $session)
    {
        $lawers = Lawyer::get();
        return view('admin.cases.editSession', compact('session', 'lawers'));
    }


    public function updateSession(Request $request, court_session_date $session)
    {
        $session->update($request->all());
        return redirect()->route('cases.all')->with('success', 'تم تعديل القضية بنجاح');
    }

    public function destroySession(Cases $case)
    {
        $case->delete();
        return redirect()->route('cases.all')->with('success', 'تم حذف القضية بنجاح');
    }

}
