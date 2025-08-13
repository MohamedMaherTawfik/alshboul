<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\archives;
use App\Models\archivesMainMenues;
use App\Models\archivesSubMenues;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = archives::get();
        $mains = archivesMainMenues::get();
        return view('admin.archive.index', compact('archives', 'mains'));
    }

    public function index1()
    {
        $archives = archives::get();
        return view('admin.archive.index1', compact('archives'));
    }

    public function create()
    {
        $archivesSubMenues = archivesSubMenues::get();
        return view('admin.archive.create', compact('archivesSubMenues'));
    }

    public function createMain()
    {
        return view('admin.archive.create', );
    }

    public function storeMain()
    {
        archivesMainMenues::create([
            'name' => request()->name,
            'added_by' => request()->user_id
        ]);
        return redirect()->route('archive.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function createSubMain($id)
    {
        return view('admin.archive.createSub', compact('id'));
    }

    public function storeSubMain()
    {
        archivesSubMenues::create([
            'name' => request()->name,
            'added_by' => request()->user_id,
            'main_menu_id' => request()->main_menu_id
        ]);
        return redirect()->route('archive.index')->with('success', 'تم الحفظ بنجاح');
    }


}