<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\excutiveCasesMain;
use App\Models\ExecutiveCase;
use App\Models\Settlement;
use App\Models\SettlementMain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExecutiveCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(excutiveCasesMain $item)
    {
        $item->load('excutiveCases');
        return view('admin.ExecutiveCase.index', compact('item'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(excutiveCasesMain $item)
    {
        $allClients = Client::all();

        $selectedClientId = old('client_id');
        $clients = $allClients;

        if ($selectedClientId) {
            $selectedClient = Client::find($selectedClientId);
            if ($selectedClient) {
                $clients = Client::where('user_id', $selectedClient->user_id)->get();
            }
        }

        // حساب أول رقم فاضي (missing number) للـ executive cases
        $numbers = $item->excutiveCases()->pluck('office_file_number')->sort()->toArray();

        $missing = 1;
        foreach ($numbers as $num) {
            if ($num == $missing) {
                $missing++;
            } elseif ($num > $missing) {
                break;
            }
        }
        return view('admin.ExecutiveCase.create', compact(
            'item',
            'clients',
            'allClients',
            'selectedClientId',
            'missing'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, excutiveCasesMain $item)
    {
        $data = $request->all();
        $client = Client::where('user_id', $data['client_id'])->first();
        $data['client_id'] = $client->id;
        $data['user_id'] = Auth::id();
        $data['excutive_cases_main_id'] = $item->id;
        try {
            ExecutiveCase::create($data);
            return redirect()->route('executive-case.index', $item)->with('success', 'تم إضافة القضية التنفيذية بنجاح');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ExecutiveCase::with(['creator', 'updater'])->findOrFail($id);
        return view('admin.ExecutiveCase.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExecutiveCase $executiveCase)
    {
        $clients = Client::all();
        return view('admin.ExecutiveCase.edit', compact('executiveCase', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExecutiveCase $executiveCase)
    {
        $data = $request->except('_token');
        // dd($data);
        try {
            DB::beginTransaction();

            // نحتفظ بالقيمة القديمة
            $oldMainCaseId = $executiveCase->excutive_cases_main_id;

            // نحدث البيانات
            $executiveCase->update($data);

            // لو اتغير نوع القضية (القضية الرئيسية)
            if ($oldMainCaseId != $executiveCase->excutive_cases_main_id) {
                // نجيب كل أرقام القضايا المرتبطة بنفس القضية الرئيسية الجديدة
                $numbers = ExecutiveCase::where('excutive_cases_main_id', $executiveCase->excutive_cases_main_id)
                    ->pluck('case_number')
                    ->sort()
                    ->toArray();

                // نحدد أول رقم ناقص
                $missing = 1;
                foreach ($numbers as $num) {
                    if ($num == $missing) {
                        $missing++;
                    } elseif ($num > $missing) {
                        break;
                    }
                }

                // نحدث رقم القضية بالرقم الجديد
                $executiveCase->update(['case_number' => $missing]);
            }

            $maincase = excutiveCasesMain::find($executiveCase->excutive_cases_main_id);

            DB::commit();
            return redirect()->route('executive-case.index', $maincase)
                ->with('success', 'تم تعديل القضية التنفيذية بنجاح، رقم الملف هو: ' . $executiveCase->case_number);

        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء التعديل: ' . $th->getMessage())
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $executiveCase = ExecutiveCase::findOrFail($request->id);

        if (!$executiveCase) {
            return redirect()->back()->with('error', 'عفواً لا توجد بيانات');
        }

        $request->validate([
            'reason' => 'required|string',
        ]);

        $executiveCase->updated_by = Auth::id();
        $executiveCase->delete_reason = $request->reason;
        $executiveCase->save();
        $executiveCase->delete();

        return redirect()->route('executive-case.index')->with('success', 'تم حذف القضية التنفيذية بنجاح');
    }

    /**
     * Display deleted executive cases
     */
    public function indexDelete()
    {
        return view('admin.ExecutiveCase.index-delete');
    }

    /**
     * Restore deleted executive case
     */
    public function restore($id)
    {
        $executiveCase = ExecutiveCase::withTrashed()->find($id);

        if (!$executiveCase) {
            return redirect()->route('executive-case.indexDelete')->with('error', 'عفواً لا توجد بيانات');
        }

        $executiveCase->updated_by = Auth::id();
        $executiveCase->delete_reason = "";
        $executiveCase->save();
        $executiveCase->restore();

        return redirect()->route('executive-case.indexDelete')->with('success', 'تم استرجاع القضية التنفيذية بنجاح');
    }

    public function caseSettlements(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('settlements');
        return view('admin.ExecutiveCase.settlements', compact('executiveCase'));
    }

    public function createSettlement(ExecutiveCase $executiveCase)
    {
        $settlements = SettlementMain::all();
        return view('admin.ExecutiveCase.create-settlement', compact('executiveCase', 'settlements'));
    }

    public function storeSettlement(Request $request, ExecutiveCase $executiveCase)
    {
        $data = $request->except('_token', 'case_type', 'case_number');
        $data['user_id'] = Auth::id();
        $data['executive_case_id'] = $executiveCase->id;
        Settlement::create($data);
        return redirect()->route('executive-case.settlement', $executiveCase)->with('success', 'تم اضافة السداد بنجاح');
    }

    public function expenses(ExecutiveCase $executiveCase)
    {
        $executiveCase->load('expenses');
        return view('admin.ExecutiveCase.expenses', compact('executiveCase'));
    }

    public function editSettlement(Settlement $settlement)
    {
        $settlements = SettlementMain::all();
        return view('admin.ExecutiveCase.edit-settlement', compact('settlement', 'settlements'));
    }

    public function updateSettlement(Request $request, Settlement $settlement)
    {
        $data = $request->except('_token', 'case_type', 'case_number');
        $settlement->update($data);
        return redirect()->route('executive-case.settlement', $settlement->excutiveCases)->with('success', 'تم تعديل السداد بنجاح');
    }

    public function deleteSettlement(Settlement $settlement)
    {
        $settlement->delete();
        return redirect()->back()->with('success', 'تم حذف السداد بنجاح');
    }

}