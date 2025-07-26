<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\Lawyer;
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

        return view('user.index',  compact('countLawyer', 'countClient', 'countClientRequest', 'countUser'));
    }
}
