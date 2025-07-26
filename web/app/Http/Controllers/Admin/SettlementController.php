<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettlementController extends Controller
{
    public function index()
    {
        $data = Settlement::with(['creator', 'updater'])->orderBy('id', 'desc')->get();
        return view('admin.Settlement.index', compact('data'));
    }

    public function create()
    {
        return view('admin.Settlement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'settlement_type' => 'required|string|max:255',
            'partner_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'client_national_id' => 'required|string|max:255',
            'opponent_name' => 'required|string|max:255',
            'opponent_national_id' => 'nullable|string|max:255',
            'opponent_status' => 'nullable|string|max:255',
            'obligation' => 'nullable|string|max:255',
            'file_number' => 'nullable|string|max:255',
            'opponent_address' => 'nullable|string|max:255',
            'opponent_phone' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,archived,canceled',
        ]);

        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['created_by'] = Auth::id();
            Settlement::create($data);
            DB::commit();
            return redirect()->route('settlement.index')->with('success', 'تم إضافة التسوية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $data = Settlement::with(['creator', 'updater'])->findOrFail($id);
        return view('admin.Settlement.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Settlement::with(['creator', 'updater'])->findOrFail($id);
        $clients = Client::all();
        $partners = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
        return view('admin.Settlement.edit', compact('data', 'clients', 'partners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'settlement_type' => 'required|string|max:255',
            'partner_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'client_national_id' => 'required|string|max:255',
            'opponent_name' => 'required|string|max:255',
            'opponent_national_id' => 'nullable|string|max:255',
            'opponent_status' => 'nullable|string|max:255',
            'obligation' => 'nullable|string|max:255',
            'file_number' => 'nullable|string|max:255',
            'opponent_address' => 'nullable|string|max:255',
            'opponent_phone' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,archived,canceled',
        ]);

        try {
            DB::beginTransaction();
            $settlement = Settlement::findOrFail($id);
            $data = $request->except('_token');
            $data['updated_by'] = Auth::id();
            $settlement->update($data);
            DB::commit();
            return redirect()->route('settlement.index')->with('success', 'تم تعديل التسوية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage())->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $settlement = Settlement::findOrFail($request->id);
        if (!$settlement) {
            return redirect()->back()->with('error', 'عفواً لا توجد بيانات');
        }
        $request->validate([
            'reason' => 'required|string',
        ]);
        $settlement->updated_by = Auth::id();
        $settlement->delete_reason = $request->reason;
        $settlement->save();
        $settlement->delete();
        return redirect()->route('settlement.index')->with('success', 'تم حذف التسوية بنجاح');
    }

    public function indexDelete()
    {
        $data = Settlement::onlyTrashed()->with(['creator', 'updater'])->get();
        return view('admin.Settlement.index-delete', compact('data'));
    }

    public function restore($id)
    {
        $settlement = Settlement::withTrashed()->find($id);
        if (!$settlement) {
            return redirect()->route('settlement.indexDelete')->with('error', 'عفواً لا توجد بيانات');
        }
        $settlement->updated_by = Auth::id();
        $settlement->delete_reason = "";
        $settlement->save();
        $settlement->restore();
        return redirect()->route('settlement.indexDelete')->with('success', 'تم استرجاع التسوية بنجاح');
    }
}
