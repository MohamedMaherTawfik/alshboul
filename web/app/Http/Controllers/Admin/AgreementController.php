<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Client;
use App\Models\Installment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Agreement::with(['creator', 'updater', 'installments'])->orderBy('id', 'desc')->get();
        return view('admin.Agreement.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $partners = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
        return view('admin.Agreement.create', compact('clients', 'partners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agreement_number' => 'required|unique:agreements,agreement_number',
            'first_party' => 'required|exists:clients,id',
            'second_party' => 'required|string',
            'agreement_date' => 'required|date',
            'subject' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'represented_by' => 'nullable|exists:users,id',
            'agreement_type' => 'nullable|in:public,private',
            'installments_count' => 'nullable|integer|min:1',
            'installment_interval_months' => 'nullable|integer|min:1',
            'first_installment_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['created_by'] = Auth::id();
            $agreement = Agreement::create($data);

            // Create installments if installment data is provided
            if ($request->installments_count && $request->first_installment_date && $request->amount) {
                $installmentAmount = $request->amount / $request->installments_count;
                $firstDate = Carbon::parse($request->first_installment_date);

                for ($i = 0; $i < $request->installments_count; $i++) {
                    $dueDate = $firstDate->copy()->addMonths($i * $request->installment_interval_months);

                    Installment::create([
                        'agreement_id' => $agreement->id,
                        'amount' => $installmentAmount,
                        'due_date' => $dueDate,
                        'is_paid' => false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('agreement.index')->with('success', 'تم إضافة الاتفاقية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Agreement::with(['creator', 'updater', 'installments'])->findOrFail($id);
        return view('admin.Agreement.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Agreement::with(['creator', 'updater', 'installments'])->findOrFail($id);
        $clients = Client::all();
        $partners = User::whereIn('role', ['superadmin', 'admin', 'Lawyer'])->get();
        return view('admin.Agreement.edit', compact('data', 'clients', 'partners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'agreement_number' => 'required|unique:agreements,agreement_number,' . $id,
            'first_party' => 'required|exists:clients,id',
            'second_party' => 'required|string',
            'agreement_date' => 'required|date',
            'subject' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'represented_by' => 'nullable|exists:users,id',
            'agreement_type' => 'nullable|in:public,private',
            'installments_count' => 'nullable|integer|min:1',
            'installment_interval_months' => 'nullable|integer|min:1',
            'first_installment_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $agreement = Agreement::findOrFail($id);
            $data = $request->except('_token');
            $data['updated_by'] = Auth::id();

            $agreement->update($data);

            // Update installments if installment data is provided
            if ($request->installments_count && $request->first_installment_date && $request->amount) {
                // Delete existing installments
                $agreement->installments()->delete();

                // Create new installments
                $installmentAmount = $request->amount / $request->installments_count;
                $firstDate = Carbon::parse($request->first_installment_date);

                for ($i = 0; $i < $request->installments_count; $i++) {
                    $dueDate = $firstDate->copy()->addMonths($i * $request->installment_interval_months);

                    Installment::create([
                        'agreement_id' => $agreement->id,
                        'amount' => $installmentAmount,
                        'due_date' => $dueDate,
                        'is_paid' => false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('agreement.index')->with('success', 'تم تعديل الاتفاقية بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $agreement = Agreement::findOrFail($request->id);

        if (!$agreement) {
            return redirect()->back()->with('error', 'عفواً لا توجد بيانات');
        }

        $request->validate([
            'reason' => 'required|string',
        ]);

        $agreement->updated_by = Auth::id();
        $agreement->delete_reason = $request->reason;
        $agreement->save();
        $agreement->delete();

        return redirect()->route('agreement.index')->with('success', 'تم حذف الاتفاقية بنجاح');
    }

    /**
     * Display deleted agreements
     */
    public function indexDelete()
    {
        $data = Agreement::onlyTrashed()->with(['creator', 'updater'])->get();
        return view('admin.Agreement.index-delete', compact('data'));
    }

    /**
     * Restore deleted agreement
     */
    public function restore($id)
    {
        $agreement = Agreement::withTrashed()->find($id);

        if (!$agreement) {
            return redirect()->route('agreement.indexDelete')->with('error', 'عفواً لا توجد بيانات');
        }

        $agreement->updated_by = Auth::id();
        $agreement->delete_reason = "";
        $agreement->save();
        $agreement->restore();

        return redirect()->route('agreement.indexDelete')->with('success', 'تم استرجاع الاتفاقية بنجاح');
    }
}
