<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseOpponents;
use App\Models\cases;
use App\Models\Client;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    public function index()
    {

        return view('admin.public.publicSearch', );
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        if ($data['client_name']) {
            $client = Client::with([
                'archives',
                'missions',
                'cases',
                'executiveCases',
                'transactions',
                'clientProcedurals'
            ])
                ->where('name', 'like', '%' . $data['client_name'] . '%')
                ->first();

            return view('admin.public.publicSearch', compact('client'));
        }

        if ($data['opponent_name']) {
            $opponent = CaseOpponents::with(['case', 'executiveCase'])
                ->where('case_opponent_name', 'like', '%' . $data['opponent_name'] . '%')
                ->first();
            return view('admin.public.showOpponents', compact('opponent'));
        }

        if ($data['case']) {
            $case = cases::with('courtSession', 'legalPeriods', 'caseNotes', 'proceduralRedords')->where('file_number', $data['case'])->first();
            return view('admin.public.showcases', compact('case'));
        }

        if ($data['court']) {
            $cases = cases::with('courtSession', 'legalPeriods', 'caseNotes', 'proceduralRedords')->where('court_name', $data['court'])->get();
            // dd($case);
            return view('admin.public.showCourts', compact('cases'));
        }
        return view('admin.public.publicSearch', );

    }
}
