<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseNotes;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\excutiveCasesMain;
use App\Models\Lawyer;
use App\Models\LegalPeriods;
use App\Models\Missions;
use App\Models\SettlementMain;
use App\Models\trahsedDays;
use App\Models\TransactionsMain;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $countLawyer = Lawyer::count();
        $countClient = Client::where('active', 1)->count();
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
        $settlementMain = SettlementMain::select('settlement_mains.id', 'settlement_mains.name')
            ->leftJoin('settlements', 'settlements.settlement_main_id', '=', 'settlement_mains.id')
            ->leftJoin('trahsed_days', 'trahsed_days.settlement_id', '=', 'settlements.id')
            ->where('trahsed_days.is_seen', 1)
            ->groupBy('settlement_mains.id', 'settlement_mains.name')
            ->selectRaw('COUNT(trahsed_days.id) as trashed_count')
            ->get();

        $executiveCasesMain = excutiveCasesMain::select('excutive_cases_mains.id', 'excutive_cases_mains.name')
            ->leftJoin('executive_cases', 'executive_cases.excutive_cases_main_id', '=', 'excutive_cases_mains.id')
            ->leftJoin('trahsed_days', 'trahsed_days.executive_case_id', '=', 'executive_cases.id')
            ->where('trahsed_days.is_seen', 1)
            ->groupBy('excutive_cases_mains.id', 'excutive_cases_mains.name')
            ->selectRaw('COUNT(trahsed_days.id) as trashed_count')
            ->get();

        $transactionsMain = TransactionsMain::select('transactions_mains.id', 'transactions_mains.name')
            ->leftJoin('trans_actions', 'trans_actions.transactions_main_id', '=', 'transactions_mains.id')
            ->leftJoin('trahsed_days', 'trahsed_days.trans_actions_id', '=', 'trans_actions.id')
            ->where('trahsed_days.is_seen', 1)
            ->groupBy('transactions_mains.id', 'transactions_mains.name')
            ->selectRaw('COUNT(trahsed_days.id) as trashed_count')
            ->get();

        // بعد ما تجيب الـ 4 collections
        $allData = collect()
            ->merge($caseTypesWithCount->map(function ($item) {
                return [
                    'name' => $item->name,
                    'trashed_count' => $item->trashed_count,
                    'days' => optional($item->NegligenceDays->first())->days,
                    'type' => 'case_type',
                    'id' => $item->id,
                ];
            }))
            ->merge($settlementMain->map(function ($item) {
                return [
                    'name' => $item->name,
                    'trashed_count' => $item->trashed_count,
                    'days' => optional($item->NegligenceDays->first())->days,
                    'type' => 'settlement',
                    'id' => $item->id,
                ];
            }))
            ->merge($executiveCasesMain->map(function ($item) {
                return [
                    'name' => $item->name,
                    'trashed_count' => $item->trashed_count,
                    'days' => optional($item->NegligenceDays->first())->days,
                    'type' => 'executive',
                    'id' => $item->id,
                ];
            }))
            ->merge($transactionsMain->map(function ($item) {
                return [
                    'name' => $item->name,
                    'trashed_count' => $item->trashed_count,
                    'days' => optional($item->NegligenceDays->first())->days,
                    'type' => 'transaction',
                    'id' => $item->id,
                ];
            }));

        return view('admin.index', compact('allData', 'countLawyer', 'countClient', 'missions', 'countClientRequest', 'countUser', 'durations', 'notes', 'caseTypes'));
    }
}
