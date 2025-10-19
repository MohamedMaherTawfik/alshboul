<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\clientProcedural;
use App\Models\ProceduralRecord;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserReportsController extends Controller
{
    public function index()
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
        return view('admin.reports.index', compact('lawyers'));
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        $user = User::where('name', 'like', '%' . $data['person_name'] . '%')->first();
        $procedurals = ProceduralRecord::with(['userLawyer', 'user'])
            ->where('user_lawyer_id', $user->id)
            ->whereBetween('created_at', [$request->from_date, $request->to_date])
            ->get();
        $casesProcedurals = ProceduralRecord::with(['userLawyer', 'user'])
            ->where('user_lawyer_id', $user->id)
            ->whereBetween('created_at', [$request->from_date . " 00:00:00", $request->to_date . " 23:59:59"])
            ->where('cases_id', '>', 0)
            ->get();

        $settlementProcedurals = ProceduralRecord::with(['userLawyer', 'user'])
            ->where('user_lawyer_id', $user->id)
            ->whereBetween('created_at', [$request->from_date . " 00:00:00", $request->to_date . " 23:59:59"])
            ->where('settlement_id', '>', 0)
            ->get();

        $transactionProcedurals = ProceduralRecord::with(['userLawyer', 'user'])
            ->where('user_lawyer_id', $user->id)
            ->whereBetween('created_at', [$request->from_date . " 00:00:00", $request->to_date . " 23:59:59"])
            ->where('trans_actions_id', '>', 0)
            ->get();

        $executiveProcedurals = ProceduralRecord::with(['userLawyer', 'user'])
            ->where('user_lawyer_id', $user->id)
            ->whereBetween('created_at', [$request->from_date . " 00:00:00", $request->to_date . " 23:59:59"])
            ->where('executive_case_id', '>', 0)
            ->get();

        $clientProcedurals = clientProcedural::with(['clientProceduralFiles'])->where('user_id', $user->id)->whereBetween('created_at', [$request->from_date, $request->to_date])->get();
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get();
        return view('admin.reports.index', compact('lawyers', 'procedurals', 'casesProcedurals', 'settlementProcedurals', 'transactionProcedurals', 'executiveProcedurals', 'clientProcedurals'));
    }
}
