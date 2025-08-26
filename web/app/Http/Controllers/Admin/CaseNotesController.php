<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseNotes;
use App\Models\cases;
use Illuminate\Http\Request;

class CaseNotesController extends Controller
{
    public function index()
    {
        $notes = CaseNotes::get();
        return view('admin.case_notes.index', compact('notes'));
    }

    public function create(cases $case)
    {
        return view('admin.case_notes.create', compact('case'));
    }

    public function store(Request $request, cases $case)
    {
        $data = $request->except('_token', 'case_number', 'case_type', 'client_name', 'opponent_name');
        $data['cases_id'] = $case->id;
        $data['user_id'] = auth()->user()->id;
        CaseNotes::create($data);
        return redirect()->route('note.all', )->with('success', 'تمت الإضافة بنجاح');
    }

    public function caseNotes(cases $case)
    {
        $notes = CaseNotes::where('cases_id', $case->id)->get();
        return view('admin.case_notes.index', compact('notes'));
    }
}
