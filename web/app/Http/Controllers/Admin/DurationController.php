<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cases;
use App\Models\court_session_date;
use App\Models\LegalPeriods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DurationController extends Controller
{
    public function index()
    {
        $durations = LegalPeriods::get();
        return view('admin.durations.all', compact('durations'));
    }

    public function createDuration(cases $case)
    {
        return view('admin.durations.create', compact('case'));
    }

    public function storeDuration(Request $request, cases $case)
    {
        $data = $request->except('_token', 'case_number', 'case_type', 'client_name', 'opponent_name');
        $data['cases_id'] = $case->id;
        $data['user_id'] = auth()->user()->id;
        LegalPeriods::create($data);
        return redirect()->route('cases.show', $case)->with('success')->with('success', 'تمت الإضافة بنجاح');
    }

    public function caseDurations(cases $case)
    {
        $durations = LegalPeriods::where('cases_id', $case->id)->get();
        return view('admin.durations.all', compact('durations'));
    }

    public function search()
    {
        return view('admin.durations.search');
    }

    public function search1(Request $request)
    {
        $query = LegalPeriods::query();

        if ($request->filled('from_date')) {
            $query->whereDate('period_start', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('period_end', '<=', $request->to_date);
        }
        $durations = $query->latest()->get();
        return view('admin.durations.search', compact('durations'));
    }

    public function submitDuration(Request $request, LegalPeriods $case)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'غير مسموح لك بتنفيذ هذا الإجراء.');
        }

        if (is_null($case->first_submitter_id)) {
            $case->update([
                'first_submitter_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'تم تسجيل الاعتماد الأول بنجاح.');
        }

        if (is_null($case->second_submitter_id)) {
            if ($case->first_submitter_id == $user->id) {
                return redirect()->back()->with('error', 'لا يمكنك الاعتماد مرتين لنفس القضية.');
            }

            $case->update([
                'second_submitter_id' => $user->id,
                'is_done' => 1
            ]);
            return redirect()->back()->with('success', 'تم تسجيل الاعتماد الثاني بنجاح ✅.');
        }

        return redirect()->back()->with('info', 'تم الاعتماد بالفعل من مستخدمين مختلفين.');
    }

}
