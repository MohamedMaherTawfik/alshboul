<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Lawyer::with('user', 'addedby', 'updateby')->orderBy('id', 'desc')->get();
        return view('admin.Lawyer.index', compact('data'));
    }
    public function indexDelete()
    {
        $data = Lawyer::onlyTrashed()->get();
        return view('admin.Lawyer.index-delete', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Lawyer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //   `cv_file`
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'id_number' => 'required|integer|unique:lawyers,id_number',
            'nationality' => 'required|string',
            'license_number' => 'required|unique:lawyers,license_number',
            'bar_association' => 'required|string',
            'specialization' => 'nullable|string',
            'license_issue_date' => 'nullable|date',
            'dob' => 'nullable|date',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // dd($request->all());

        $user = new User();
        $user->name = $request->username;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->address = $request->address;
        $user->date = now();
        $user->role = 'Lawyer';
        $user->added_by = Auth::id();
        $user->save();
        $path = null;
        if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
            $path = $request->file('cv_file')->store('upload_cv', 'public');
        }
        $Lawyer = new Lawyer();
        $Lawyer->name = $request->name;
        $Lawyer->phone = $request->phone;
        $Lawyer->address = $request->address;
        $Lawyer->specialization = $request->specialization ?? null;
        $Lawyer->license_number = $request->license_number;
        $Lawyer->license_issue_date = $request->license_issue_date ?? null;
        $Lawyer->bar_association = $request->bar_association;
        $Lawyer->dob = $request->dob ?? null;
        $Lawyer->cv_file = $path;
        $Lawyer->id_number = $request->id_number;
        $Lawyer->nationality = $request->nationality;
        $Lawyer->user_id = $user->id;
        $Lawyer->added_by = Auth::id();
        $Lawyer->save();

        return redirect()->route('lawyer.index')->with('success', 'تم إضافة البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Lawyer::findOrFail($id);
        return view('admin.Lawyer.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Lawyer::findOrFail($id);
        return view('admin.Lawyer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {


            DB::beginTransaction();

            $user = User::where('email', $request->email)->first();
            // dd($user);
            if (!$user) {
                return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
            }
            $Lawyer = Lawyer::findOrFail($id);
            if (!$Lawyer) {
                return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
            }
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id),
                ],
                'phone' => 'required',
                'address' => 'required',
                'id_number' => [
                    'required',
                    'integer',
                    Rule::unique('lawyers', 'id_number')->ignore($Lawyer->id),
                ],
                'nationality' => 'required|string',
                'license_number' => [
                    'required',
                    Rule::unique('lawyers', 'license_number')->ignore($Lawyer->id),
                ],
                'bar_association' => 'required|string',
                'specialization' => 'nullable|string',
                'license_issue_date' => 'nullable|date',
                'dob' => 'nullable|date',
                'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $data = $request->except(['email', '_token']);

            $path = null;
            if ($request->hasFile('cv_file') && $request->file('cv_file')->isValid()) {
                $path = $request->file('cv_file')->store('upload_cv', 'public');
                $data['cv_file'] = $path;
            } else {
                unset($data['cv_file']);
            }
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = now();
            Lawyer::where(['id' => $id])->update($data);
            $user = Lawyer::find($id);
            User::where('id', $user->user_id)->update([
                'email' => $request->email,
                'updated_by' => Auth::id(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('lawyer.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ  ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $Lawyer = Lawyer::findOrFail($request->id);
        if (!$Lawyer) {
            return redirect()->back()->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $Lawyer->updated_by = Auth::id();
        $Lawyer->delete_reason = $request->reason;
        $Lawyer->save();

        $user = User::findOrFail($Lawyer->user_id);
        $user->updated_by = Auth::id();
        $user->delete_reason = $request->reason;
        $user->active = 0;
        $user->save();
        $Lawyer->delete();
        $user->delete();
        return redirect()->route('lawyer.index')->with(['success' => 'تم حذف البيانات بنجاح']);
    }
    public function restore($id)
    {
        Lawyer::withTrashed()->find($id)->restore();

        $Lawyer = Lawyer::findOrFail($id);
        if (!$Lawyer) {
            return redirect()->route('lawyer.indexDelete')->with(['error' => 'عفواً لا توجد بيانات']);
        }
        $Lawyer->updated_by = Auth::id();
        $Lawyer->delete_reason = "";
        $Lawyer->save();

        User::withTrashed()->find($Lawyer->user_id)->restore();

        $user = User::findOrFail($Lawyer->user_id);
        $user->updated_by = Auth::id();
        $user->delete_reason = "";
        $user->active = 1;
        $user->save();


        return redirect()->route('lawyer.indexDelete')->with(['success' => 'تم استرجاع البيانات بنجاح']);
    }
}
