<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        try {
            $data = SocialLink::first();
            return view('admin.SocialLinks.index', compact('data'));
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function edit()
    {
        try {
            $data = SocialLink::first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }
            return view('admin.SocialLinks.edit', compact('data'));
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = SocialLink::first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
            }

            $data->update([
                'facebook' => $request->facebook,
                'x' => $request->x,
                'instagram' => $request->instagram,
                'whatsapp' => $request->whatsapp,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_spical' => $request->phone_spical,
                'fax' => $request->fax
            ]);

            return redirect()->route('sociallinks.index')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ']);
        }
    }
}
