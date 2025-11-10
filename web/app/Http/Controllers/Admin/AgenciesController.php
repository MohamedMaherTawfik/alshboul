<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\agencies;
use App\Models\Client;
use App\Models\MainAgencies;
use App\Models\User;
use Illuminate\Http\Request;

class AgenciesController extends Controller
{
    public function index(MainAgencies $main)
    {
        $agencies = agencies::where('main_agencies_id', '=', $main->id)->get();
        return view('admin.agencies.index', compact('agencies', 'main'));
    }

    public function create(MainAgencies $main)
    {
        $users = User::where('role', '=', 'user')->get();
        return view('admin.agencies.create', compact('main', 'users'));
    }


    public function store(Request $request, MainAgencies $main)
    {

        $request->validate([
            'user_id' => 'required',
            'lawyers' => 'required',
            'letter' => 'required',
            'opponents' => 'required',
            'court' => 'required',
            'for' => 'required',
            'created_at' => 'required',
        ]);
        $data = $request->except('_token');
        $data['main_agencies_id'] = $main->id;
        agencies::create(
            [
                'main_agencies_id' => $main->id,
                'user_id' => $data['user_id'],
                'lawyers' => $data['lawyers'],
                'letter' => $data['letter'],
                'opponents' => $data['opponents'],
                'court' => $data['court'],
                'for' => $data['for'],
                'created_at' => $data['created_at'],
            ]
        );
        return redirect()->route('agencies.index', $main->id);
    }

    public function edit(agencies $main)
    {
        $users = User::where('role', '=', 'user')->get();
        return view('admin.agencies.edit', compact('main', 'users'));
    }

    public function update(Request $request, agencies $main)
    {
        $request->validate([
            'user_id' => 'required',
            'lawyers' => 'required',
            'letter' => 'required',
            'opponents' => 'required',
            'court' => 'required',
            'for' => 'required',
            'created_at' => 'required',
        ]);
        $data = $request->except('_token ', 'user_name ');
        $main->update([
            'user_id' => $data['user_id'],
            'lawyers' => $data['lawyers'],
            'letter' => $data['letter'],
            'opponents' => $data['opponents'],
            'court' => $data['court'],
            'for' => $data['for'],
            'created_at' => $data['created_at'],
        ]);
        return redirect()->route('agencies.index', $main->main_agencies_id);
    }

    public function delete(agencies $main)
    {
        $main->delete();
        return redirect()->route('agencies.index', $main->main_agencies_id);
    }
}
