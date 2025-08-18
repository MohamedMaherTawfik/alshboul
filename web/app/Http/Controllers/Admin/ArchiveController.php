<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\archiveRequest;
use App\Http\Requests\archiveUpdateRequest;
use App\Models\archives;
use App\Models\archivesMainMenues;
use App\Models\archivesSubMenues;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = archives::where('active', 1)->get();
        $mains = archivesMainMenues::get();
        $subs = archivesSubMenues::get();
        $clients = Client::get();
        return view('admin.archive.index', compact('archives', 'mains', 'subs', 'clients'));
    }

    public function index1()
    {
        $archives = archives::get();
        $archiveMainMenues = archivesMainMenues::get();
        $archivesSubMenues = archivesSubMenues::get();
        return view('admin.archive.index1', compact('archives', 'archiveMainMenues', 'archivesSubMenues'));
    }

    public function create()
    {
        $archivesSubMenues = archivesSubMenues::get();
        $archiveMainMenues = archivesMainMenues::get();
        $clients = Client::get();
        return view('admin.archive.createArchive', compact('archivesSubMenues', 'archiveMainMenues', 'clients'));
    }

    public function store(archiveRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('archives', 'public');
        }
        $archive = archives::create($validated);
        return redirect()->route('archive.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function edit(archives $archive)
    {
        $archivesSubMenues = archivesSubMenues::get();
        $archiveMainMenues = archivesMainMenues::get();
        $clients = Client::get();
        return view('admin.archive.edit', compact('archive', 'archivesSubMenues', 'archiveMainMenues', 'clients'));
    }

    public function update(archiveUpdateRequest $request, archives $archive)
    {
        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('archives', 'public');
        }
        $archive->update($validated);
        return redirect()->route('archive.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Request $request, archives $archive)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = Auth::user();
        if ($user->email === $request->email && Hash::check($request->password, $user->password)) {
            $archive->update(['active' => 0]);
            return redirect()->route('archive.index')->with('success', 'تم الاضافه الي سله المحذوفات');
        }
        abort(401, 'Unauthorized Action !');
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
            'added_by' => Auth::user()->id,
            'document_number' => request()->document_number,
            'main_menu_id' => request()->main_id
        ]);
        return redirect()->route('archive.index')->with('success', 'تم الحفظ بنجاح');
    }


    public function deletedArchive()
    {
        $archives = archives::where('active', 0)->get();
        return view('admin.archive.indexDeleted', compact('archives'));
    }

    public function restore(archives $archive)
    {
        $archive->update(['active' => 1]);
        return redirect()->route('archive.index')->with('success', 'تم التعديل بنجاح');
    }

    public function search(Request $request)
    {
        $query = archives::query();

        // فلترة بالتاريخ
        if ($request->filled('from_date')) {
            $query->whereDate('time', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('time', '<=', $request->to_date);
        }

        // فلترة بالقسم الرئيسي
        if ($request->filled('main_menu_id')) {
            $query->whereHas('archivesSubMenues', function ($q) use ($request) {
                $q->where('main_menu_id', $request->main_menu_id);
            });
        }

        // فلترة بالقسم الفرعي
        if ($request->filled('sub_menu_id')) {
            $query->where('sub_menu_id', $request->sub_menu_id);
        }

        $archives = $query->latest()->get();

        $archiveMainMenues = archivesMainMenues::all();
        $archivesSubMenues = archivesSubMenues::all();
        return view('admin.archive.index1', compact('archives', 'archiveMainMenues', 'archivesSubMenues'));

    }
}
