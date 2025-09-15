<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cases;
use App\Models\ExecutiveCase;
use App\Models\Settlement;
use App\Models\TransActions;
use Illuminate\Http\Request;

class TrashedController extends Controller
{
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
        return view('admin.trash.cases', compact('cases'));
    }

    public function trashedSettlements($settlementId)
    {
        $settlements = Settlement::where('settlement_main_id', $settlementId)
            ->whereHas('trahsedDays', function ($query) {
                $query->where('is_seen', 1);
            })
            ->with([
                'trahsedDays' => function ($query) {
                    $query->where('is_seen', 1);
                }
            ])
            ->get();
        return view('admin.trash.settlements', compact('settlements'));
    }

    public function trashedExecutives($executiveCaseId)
    {

        $executiveCases = ExecutiveCase::where('excutive_cases_main_id', $executiveCaseId)
            ->whereHas('trahsedDays', function ($query) {
                $query->where('is_seen', 1);
            })
            ->with([
                'trahsedDays' => function ($query) {
                    $query->where('is_seen', 1);
                }
            ])
            ->get();
        return view('admin.trash.executives', compact('executiveCases'));
    }

    public function trashedTransactions($transactionId)
    {
        $transactions = TransActions::where('transactions_main_id', $transactionId)
            ->whereHas('trahsedDays', function ($query) {
                $query->where('is_seen', 1);
            })
            ->with([
                'trahsedDays' => function ($query) {
                    $query->where('is_seen', 1);
                }
            ])
            ->get();
        return view('admin.trash.transactions', compact('transactions'));
    }
}