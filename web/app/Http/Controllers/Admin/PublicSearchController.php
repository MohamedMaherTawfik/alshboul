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
        $clients = Client::where('seen', 1)->get();
        $opponents = CaseOpponents::get();
        return view('admin.public.publicSearch', compact('clients', 'opponents'));
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        if ($data['client_id']) {
            $clients = Client::where('seen', 1)->get();
            $opponents = CaseOpponents::get();
            $client = Client::with('archives', 'missions', 'cases', 'executiveCases', 'Transactions', 'clientProcedurals')->where('id', $data['client_id'])->first();
            return view('admin.public.publicSearch', compact('client', 'clients', 'opponents'));
        }

        if ($data['opponent_id']) {
            $clients = Client::where('seen', 1)->get();
            $opponents = CaseOpponents::get();
            $opponent = CaseOpponents::with('case', 'executiveCase')->where('id', $data['opponent_id'])->first();
            return view('admin.public.showOpponents', compact('opponent', 'clients', 'opponents'));
        }

        if ($data['case']) {
            $clients = Client::where('seen', 1)->get();
            $opponents = CaseOpponents::get();
            $case = cases::with('courtSession', 'legalPeriods', 'caseNotes', 'proceduralRedords')->where('file_number', $data['case'])->first();
            return view('admin.public.showcases', compact('case', 'clients', 'opponents'));
        }

        if ($data['court']) {
            $clients = Client::where('seen', 1)->get();
            $opponents = CaseOpponents::get();
            $court = cases::with('courtSession', 'legalPeriods', 'caseNotes', 'proceduralRedords')->where('court_name', $data['court'])->get();
            return view('admin.public.showCourts', compact('court', 'clients', 'opponents'));
        }
        $clients = Client::where('seen', 1)->get();
        $opponents = CaseOpponents::get();
        return view('admin.public.publicSearch', compact('clients', 'opponents'));

    }
}