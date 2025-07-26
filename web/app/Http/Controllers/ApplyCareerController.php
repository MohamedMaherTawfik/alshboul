<?php

namespace App\Http\Controllers;

use App\Models\ApplyCareer;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplyCareerController extends Controller
{
    public function index()
    {
        $applyCareers = ApplyCareer::with('career')->latest()->get();
        return view('apply-careers.index', compact('applyCareers'));
    }

    public function create()
    {
        $careers = Career::where('active', 1)->get();
        return view('apply-careers.create', compact('careers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'brith_date' => 'required|date',
            'career_id' => 'required|exists:careers,id',
            'phone' => 'required|string|max:20',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cv_file')) {
            $cvFile = $request->file('cv_file');
            $cvFileName = time() . '_' . $cvFile->getClientOriginalName();
            $cvFile->storeAs('public/cv_files', $cvFileName);
            $data['cv_file'] = $cvFileName;
        }

        ApplyCareer::create($data);

        return redirect()->back()
            ->with('success', app()->getLocale() == 'ar' ? 'تم إرسال طلب التوظيف بنجاح' : 'Career application submitted successfully');
    }

    public function show($id)
    {
        $applyCareer = ApplyCareer::with('career')->findOrFail($id);
        return view('apply-careers.show', compact('applyCareer'));
    }

    public function edit($id)
    {
        $applyCareer = ApplyCareer::findOrFail($id);
        $careers = Career::where('active', 1)->get();
        return view('apply-careers.edit', compact('applyCareer', 'careers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'brith_date' => 'required|date',
            'career_id' => 'required|exists:careers,id',
            'phone' => 'required|string|max:20',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $applyCareer = ApplyCareer::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('cv_file')) {
            // Delete old file
            if ($applyCareer->cv_file) {
                Storage::delete('public/cv_files/' . $applyCareer->cv_file);
            }

            $cvFile = $request->file('cv_file');
            $cvFileName = time() . '_' . $cvFile->getClientOriginalName();
            $cvFile->storeAs('public/cv_files', $cvFileName);
            $data['cv_file'] = $cvFileName;
        }

        $applyCareer->update($data);

        return redirect()->route('apply-careers.index')
            ->with('success', app()->getLocale() == 'ar' ? 'تم تحديث طلب التوظيف بنجاح' : 'Career application updated successfully');
    }

    public function destroy($id)
    {
        $applyCareer = ApplyCareer::findOrFail($id);

        // Delete CV file
        if ($applyCareer->cv_file) {
            Storage::delete('public/cv_files/' . $applyCareer->cv_file);
        }

        $applyCareer->delete();

        return redirect()->route('apply-careers.index')
            ->with('success', app()->getLocale() == 'ar' ? 'تم حذف طلب التوظيف بنجاح' : 'Career application deleted successfully');
    }
}
