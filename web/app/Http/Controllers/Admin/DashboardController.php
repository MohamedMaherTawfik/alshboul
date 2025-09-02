<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseNotes;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\Lawyer;
use App\Models\LegalPeriods;
use App\Models\Missions;
use App\Models\NegligenceDays;
use App\Models\trahsedDays;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $countLawyer = Lawyer::count();
        $countClient = Client::count();
        $countClientRequest = ClientRequest::count();
        $countUser = User::count();
        $caseTypes = CaseType::with('suggestedCases')->get();
        $today = date('Y-m-d');
        $sixDaysLater = date('Y-m-d', strtotime('+6 days'));
        $durations = LegalPeriods::where('is_done', 0)->whereBetween('period_end', [$today, $sixDaysLater])->get();
        $notes = CaseNotes::where('is_done', 0)->whereBetween('period_end', [$today, $sixDaysLater])->get();
        $missions = Missions::where('is_done', 0)->count();

        $caseTypesWithCount = CaseType::select('case_types.id', 'case_types.name')
            ->leftJoin('cases', 'cases.suggested_case_id', '=', 'case_types.id')
            ->leftJoin('trahsed_days', 'trahsed_days.cases_id', '=', 'cases.id')
            ->where('trahsed_days.is_seen', 1)
            ->groupBy('case_types.id', 'case_types.name')
            ->selectRaw('COUNT(trahsed_days.id) as trashed_count')
            ->get();


        return view('admin.index', compact('caseTypesWithCount', 'countLawyer', 'countClient', 'missions', 'countClientRequest', 'countUser', 'durations', 'notes', 'caseTypes'));
    }
}