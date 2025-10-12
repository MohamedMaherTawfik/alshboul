<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProceduralRecord;
use App\Models\subNav;
use App\Models\User;
use Illuminate\Http\Request;

class subNavController extends Controller
{
    public function index(subNav $nav)
    {
        $nav->load('proceduralRecords');
        return view('admin.subNav.index', compact('nav'));
    }

    public function create(subNav $nav)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.subNav.create', compact('nav', 'lawyers'));
    }

    public function store(Request $request, subNav $nav)
    {
        $data = $request->except('_token');
        ProceduralRecord::create([
            'sub_nav_id' => $nav->id,
            'user_id' => $data['user_id'],
            'user_lawyer_id' => $data['user_lawyer_id'],
            'created_at' => $data['created_at'],
            'note' => $data['note'],
            'action' => $data['action'],
            'next_action' => $data['next_action'],
            'next_action_date' => $data['next_action_date'],
        ]);
        return redirect()->route('subNav.index', $nav)->with('success', 'تم الاضافة بنجاح');
    }

    public function edit(ProceduralRecord $nav)
    {
        $lawyers = User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->where('active', 1)->get();
        return view('admin.subNav.edit', compact('nav', 'lawyers'));
    }

    public function update(Request $request, ProceduralRecord $nav)
    {
        $data = $request->except('_token');
        $nav->update($data);
        return redirect()->route('subNav.index', $nav->subNav)->with('success', 'تم التعديل بنجاح');
    }

    public function delete(ProceduralRecord $nav)
    {
        $nav->delete();
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
