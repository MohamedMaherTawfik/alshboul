<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AboutUs::select("*")->orderby('id', 'DESC')->paginate(10);
        return view('admin.AboutUs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.AboutUs.create');
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
                $image->move(public_path('uploads/about_us'), $imageName);
                $data['image'] = 'uploads/about_us/' . $imageName;
            }

            DB::beginTransaction();
            AboutUs::create($data);
            DB::commit();
            return redirect()->route('aboutus.index')->with(['success' => 'تم اضافة البيانات بنجاح']);
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
        $data = AboutUs::select("*")->where('id', $id)->first();
        return view('admin.AboutUs.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = AboutUs::find($id);
            if (empty($data)) {
                return redirect()->route('aboutus.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
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
                $image->move(public_path('uploads/about_us'), $imageName);
                $updateData['image'] = 'uploads/about_us/' . $imageName;
            }

            AboutUs::where('id', $id)->update($updateData);
            DB::commit();
            return redirect()->route('aboutus.index')->with(["success" => 'تم تعديل البيانات بنجاح']);
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
            $data = AboutUs::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
            }

            // Delete image if exists
            if ($data->image && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            if (AboutUs::where('id', $id)->delete()) {
                return redirect()->back()->with(['success' => 'تم حذف البيانات بنجاح']);
            }
        } catch (\Exception $th) {
            return redirect()->back()->with(['error' => 'عفواً حدث خطأ' . $th->getMessage()])->withInput();
        }
    }
}
