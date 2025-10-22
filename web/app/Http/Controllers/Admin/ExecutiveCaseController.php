<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseOpponents;
use App\Models\Client;
use App\Models\excutiveCasesMain;
use App\Models\ExecutiveCase;
use App\Models\NegligenceDays;
use App\Models\ProceduralFile;
use App\Models\ProceduralRecord;
use App\Models\Settlement;
use App\Models\SettlementMain;
use App\Models\subrocedural;
use App\Models\trahsedDays;
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
        // جلب كل القضايا التنفيذية
        $executiveCases = ExecutiveCase::where('excutive_cases_main_id', $item->id)->get();
        $casesId = $executiveCases->pluck('id')->toArray();

        // إعدادات الإهمال
        $neglectConfig = NegligenceDays::where('excutive_cases_main_id', $item->id)->first();

        // مصفوفة IDs لكل القضايا اللي عندها تسويات
        $more = Settlement::whereIn('executive_case_id', $casesId)
            ->pluck('executive_case_id')
            ->toArray();

        if ($neglectConfig && $neglectConfig->days != 0) {
            foreach ($executiveCases as $case) {
                $totalEvents = $case->proceduralRecords()->count() + $case->settlements()->count();

                // إنشاء سجل trash لو مش موجود
                $trashed = trahsedDays::firstOrCreate(
                    ['executive_case_id' => $case->id],
                    [
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]
                );

                // تحديث سجل الإهمال
                $daysDiff = now()->diffInDays($trashed->updated_at);

                if ($totalEvents == $trashed->counts) {
                    if ($daysDiff >= 1) {
                        $trashed->increment('days_passed', $daysDiff);
                    }

                    if ($trashed->days_passed >= $neglectConfig->days) {
                        $trashed->update(['is_seen' => 1]);
                    }
                } elseif ($totalEvents > $trashed->counts) {
                    $trashed->update([
                        'counts' => $totalEvents,
                        'days_passed' => 0,
                        'is_seen' => 0,
                    ]);
                }
            }
        }

        return view('admin.ExecutiveCase.index', compact('item', 'executiveCases', 'neglectConfig', 'more'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(excutiveCasesMain $item)
    {
        $allClients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
        $users = User::with('client')->where('role', 'user')->where('active', 1)->get();
        $selectedClientId = old('client_id');
        $clients = $allClients;

        if ($selectedClientId) {
            $selectedClient = Client::find($selectedClientId);
            if ($selectedClient) {
                $clients = Client::where('user_id', $selectedClient->user_id)->get();
            }
        }

        $numbers = $item->excutiveCases()->pluck('file_number')->sort()->toArray();

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
            'users',
            'missing'
        ));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, excutiveCasesMain $item)
    {
        $data = $request->all();
        $client = Client::where('user_id', $data['user_id'])->first();
        $data['client_id'] = $client->id;
        $data['user_id'] = Auth::id();
        $data['excutive_cases_main_id'] = $item->id;
        try {
            $executiveCase = ExecutiveCase::create([
                'file_number' => $data['file_number'],
                'client_name' => $data['client_name'],
                'client_id' => $data['client_id'],
                'user_id' => $data['user_id'],
                'excutive_cases_main_id' => $data['excutive_cases_main_id'],
                'subscriber_number' => $data['subscriber_number'],
                'client_national_id' => $data['client_national_id'],
                'case_number' => $data['case_number'],
                'case_type' => $data['case_type'],
                'case_status' => $data['case_status'],
                'case_value' => $data['case_value'],
                'judged_against' => $data['judged_against'],
                'judged_for' => $data['judged_for'],
                'execution_court' => $data['execution_court'],
                'execution_document_number' => $data['execution_document_number'],
                'execution_document_type' => $data['execution_document_type'],
                'procedural_session_date' => $data['procedural_session_date'],
            ]);

            // ✅ حفظ الخصوم المتعددين
            if ($request->has('opponents')) {
                foreach ($request->opponents as $opponent) {
                    if (!empty($opponent['name'])) {
                        CaseOpponents::create([
                            'executive_case_id' => $executiveCase->id,
                            'case_opponent_name' => $opponent['name'],
                            'case_opponent_national_number' => $opponent['national_id'] ?? '',
                            'case_opponent_description' => '',
                        ]);
                    }
                }
            }

            return redirect()->route('executive-case.index', $item)
                ->with('success', 'تم إضافة القضية التنفيذية بنجاح');
        } catch (\Exception $th) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء الإضافة: ' . $th->getMessage())
                ->withInput();
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

        $clients = Client::with('user')->where('seen', 1)->where('active', 1)->orderBy('id', 'desc')->get();
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

            $oldMainCaseId = $executiveCase->excutive_cases_main_id;

            $executiveCase->update($data);

            if ($oldMainCaseId != $executiveCase->excutive_cases_main_id) {
                $numbers = ExecutiveCase::where('excutive_cases_main_id', $executiveCase->excutive_cases_main_id)
                    ->pluck('file_number')
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
                $executiveCase->update(['file_number' => $missing]);
            }

            $maincase = excutiveCasesMain::find($executiveCase->excutive_cases_main_id);

            DB::commit();
            return redirect()->route('executive-case.index', $maincase)
                ->with('success', 'تم تعديل القضية التنفيذية بنجاح، رقم الملف هو: ' . $executiveCase->file_number);

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
    public function destroy(Request $request, ExecutiveCase $executiveCase)
    {
        $executiveCase->delete();
        return redirect()->back()->with('success', 'تم حذف القضية التنفيذية بنجاح');
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
        $data = $request->except('_token', 'case_type', 'case_number', 'file_number');

        try {
            DB::beginTransaction();
            // نجيب كل أرقام الملفات الخاصة بالـ Main Settlement
            $numbers = Settlement::where('settlement_main_id', $data['settlement_main_id'])
                ->where('id', '!=', $settlement->id) // نستثني نفس السجل
                ->pluck('file_number')
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

            // نحدد رقم الملف الجديد
            $data['file_number'] = $missing;

            // نحدث السداد
            $settlement->update($data);

            DB::commit();

            return redirect()
                ->route('settlement.index', $settlement->settlementMain)
                ->with('success', 'تم تعديل السداد بنجاح، رقم الملف هو: ' . $data['file_number']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'حصل خطأ أثناء التعديل: ' . $e->getMessage())
                ->withInput();
        }
    }




    public function deleteSettlement(Settlement $settlement)
    {
        $settlement->delete();
        return redirect()->back()->with('success', 'تم حذف السداد بنجاح');
    }

    public function executiveProcedural(ProceduralRecord $executiveCase)
    {
        $executiveCase->load('subProcedurals');
        return view('admin.ExecutiveCase.procedural', compact('executiveCase'));
    }

    public function addFile(Request $request, ProceduralRecord $executiveCase)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('ProceduralFiles', 'public');

                ProceduralFile::create([
                    'procedural_record_id' => $executiveCase->id,
                    'created_by' => Auth::user()->id,
                    'file_path' => $path,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }


        return redirect()->route('procedural-record.index', $executiveCase->case)
            ->with('success', 'تم رفع الملف بنجاح');
    }

    public function subProcedural(Request $request, ProceduralRecord $executiveCase)
    {
        $data = $request->except('_token', 'file');
        $data['procedural_record_id'] = $executiveCase->id;
        subrocedural::create($data);
        return redirect()->route('executive-case.procedural.show', $executiveCase)
            ->with('success', 'تم تسجيل الاجراء بنجاح');
    }

}
