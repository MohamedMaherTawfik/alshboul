<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CaseType::select("*")->orderby('id', 'DESC')->paginate(10);
        return view('admin.CaseTypes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.CaseTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/case_types'), $imageName);
                $data['image'] = 'uploads/case_types/' . $imageName;
            }

            DB::beginTransaction();
            CaseType::create($data);
            DB::commit();
            return redirect()->route('casetypes.index')->with(['success' => 'تم اضافة نوع القضية بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(["error" => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = CaseType::select("*")->where('id', $id)->first();
        return view('admin.CaseTypes.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = CaseType::find($id);
            if (empty($data)) {
                return redirect()->route('casetypes.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }

            DB::beginTransaction();
            $updateData = $request->except(['_token']);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($data->image && file_exists(public_path($data->image))) {
                    unlink(public_path($data->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/case_types'), $imageName);
                $updateData['image'] = 'uploads/case_types/' . $imageName;
            }

            CaseType::where('id', $id)->update($updateData);
            DB::commit();
            return redirect()->route('casetypes.index')->with(["success" => 'تم تعديل البيانات بنجاح']);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = CaseType::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
            }

            // Delete image if exists
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            if (CaseType::where('id', $id)->delete()) {
                return redirect()->back()->with(['success' => 'تم حذف البيانات بنجاح']);
            }
        } catch (\Exception $th) {
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }
}
