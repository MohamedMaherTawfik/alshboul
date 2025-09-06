<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseOpponents;
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
        $client = Client::with('archives', 'missions', 'cases', 'executiveCases', 'Transactions', 'clientProcedurals')->where('id', $data['client_id'])->first();
        dd($client);
    }
}
