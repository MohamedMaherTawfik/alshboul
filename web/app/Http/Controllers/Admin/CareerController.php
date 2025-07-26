<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::latest()->get();
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        Career::create($request->all());

        return redirect()->route('careers.index')
            ->with('success', 'تم إضافة الوظيفة بنجاح');
    }

    public function edit($id)
    {
        $career = Career::findOrFail($id);
        return view('admin.careers.edit', compact('career'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        $career = Career::findOrFail($id);
        $career->update($request->except(['_token']));

        return redirect()->route('careers.index')
            ->with('success', 'تم تحديث الوظيفة بنجاح');
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return redirect()->route('careers.index')
            ->with('success', 'تم حذف الوظيفة بنجاح');
    }
    public function apply()
    {
        return view('admin.ApplyJob.index');
    }
}
