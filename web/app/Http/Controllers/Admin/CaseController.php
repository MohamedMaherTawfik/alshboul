<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseRequest;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\court_session_date;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function allCases()
    {
        $cases = Cases::with([
            'courtSession' => function ($q) {
                $q->orderBy('id', 'DESC');
            }
        ])->get();
        return view('admin.CaseTypes.allCases', compact('cases', ));
    }

    public function createCase(CaseType $caseType)
    {
        $clients = Client::get();
        return view('admin.CaseTypes.createCase', compact('caseType', 'clients'));
    }

    public function storeCase(CaseRequest $request, CaseType $caseType)
    {
        $data = $request->validated();
        $data['added_by_id'] = auth()->user()->id;
        cases::create($data);
        return redirect()->route('casetypes.index')->with(['success' => 'تم اضافة القضية بنجاح']);
    }

    public function edit(Cases $case)
    {
        $clients = Client::get();
        return view('admin.cases.edit', compact('case', 'clients'));
    }

    public function update(Request $request, Cases $case)
    {
        $case->update($request->all());
        return redirect()->route('cases.all')->with('success', 'تم تعديل القضية بنجاح');
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
        return redirect()->route('cases.all')->with('success', 'تمت الإضافة بنجاح');
    }

    public function settlement(Cases $case)
    {
        return view('admin.cases.settlement', compact('case'));
    }

    public function storeSettlement(Request $request, Cases $case)
    {
        return redirect()->route('admin.cases.all')->with('success', 'تم تسجيل التسوية بنجاح');
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
}
