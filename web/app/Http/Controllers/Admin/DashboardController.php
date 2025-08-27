<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseNotes;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\Lawyer;
use App\Models\LegalPeriods;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $countLawyer = Lawyer::count();
        $countClient = Client::count();
        $countClientRequest = ClientRequest::count();
        $countUser = User::count();

        $today = date('Y-m-d');
        $sixDaysLater = date('Y-m-d', strtotime('+6 days'));
        $durations = LegalPeriods::where('is_done', 0)->whereBetween('period_end', [$today, $sixDaysLater])->get();
        $notes = CaseNotes::where('is_done', 0)->whereBetween('period_end', [$today, $sixDaysLater])->get();
        return view('admin.index', compact('countLawyer', 'countClient', 'countClientRequest', 'countUser', 'durations', 'notes'));
    }
}
