<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $data = Slider::select("*")->orderby('id', 'DESC')->paginate(10);
            return view('admin.Sliders.index', compact('data'));
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function create()
    {
        return view('admin.Sliders.create');
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $file_extension = $image->getClientOriginalExtension();
                    $file_name = Str::uuid() . '.' . $file_extension;

                    $path = 'uploads/sliders';
                    $image->move($path, $file_name);

                    Slider::create([
                        'image' => $path . '/' . $file_name
                    ]);
                }
            }

            return redirect()->route('sliders.index')->with(['success' => 'تم الاضافة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function edit($id)
    {
        try {
            $data = Slider::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            return view('admin.Sliders.edit', compact('data'));
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Slider::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }

            if ($request->hasFile('image')) {
                // Delete old image
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }

                $file_extension = $request->file('image')->getClientOriginalExtension();
                $file_name = time() . '.' . $file_extension;
                $path = 'uploads/sliders';
                $request->file('image')->move($path, $file_name);

                $data->update([
                    'image' => $path . '/' . $file_name
                ]);
            }

            return redirect()->route('sliders.index')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Slider::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }

            // Delete image file
            if (File::exists($data->image)) {
                File::delete($data->image);
            }

            $data->delete();
            return redirect()->route('sliders.index')->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }
}
