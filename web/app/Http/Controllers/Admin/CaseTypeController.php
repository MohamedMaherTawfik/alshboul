<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cases;
use App\Models\CaseType;
use App\Models\excutiveCasesMain;
use App\Models\ExecutiveCase;
use App\Models\MainNav;
use App\Models\NegligenceDays;
use App\Models\Settlement;
use App\Models\SettlementMain;
use App\Models\subNav;
use App\Models\trahsedDays;
use App\Models\TransactionsMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CaseType::select("*")->orderby('id', 'DESC')->get(10);
        $settlements = SettlementMain::select("*")->orderby('id', 'DESC')->get(10);
        $transactions = TransactionsMain::select("*")->orderby('id', 'DESC')->get(10);
        $excutiveCases = excutiveCasesMain::select("*")->orderby('id', 'DESC')->get(10);
        $subNavs = subNav::with('mainNav')->get();
        $mainNavs = MainNav::with('subNav')->get();
        return view('admin.CaseTypes.index', compact('data', 'settlements', 'transactions', 'excutiveCases', 'subNavs', 'mainNavs'));
    }
    public function show(CaseType $casetype)
    {
        $more = []; // مصفوفة لتخزين IDs القضايا اللي ليها تسويات

        $cases = Cases::with('caseOpponents')
            ->where('suggested_case_id', $casetype->id)
            ->where('active', 1)
            ->get()
            ->sortBy('case_number');

        $casesId = $cases->pluck('id')->toArray();

        // جلب كل التسويات المتعلقة بالقضايا
        $settlements = Settlement::whereIn('cases_id', $casesId)->get();
        if ($settlements->count()) {
            $more = $settlements->pluck('cases_id')->toArray();
        }

        $neglectConfig = NegligenceDays::where('case_type_id', $casetype->id)->first();

        if ($neglectConfig) {

            // لو days = 0 نعمل تجاهل للإهمال
            if ($neglectConfig->days > 0) {

                foreach ($cases as $case) {
                    $totalEvents = $case->courtSession()->count()
                        + $case->legalPeriods()->count()
                        + $case->caseNotes()->count()
                        + $case->proceduralRedords()->count();

                    // إنشاء سجل trash لو مش موجود
                    $trashed = trahsedDays::firstOrCreate(
                        ['cases_id' => $case->id],
                        [
                            'counts' => $totalEvents,
                            'days_passed' => 0,
                            'is_seen' => 0,
                        ]
                    );

                    // تحديث سجل الإهمال
                    $daysDiff = now()->diffInDays($trashed->created_at);

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
        }

        return view('admin.CaseTypes.show', compact('casetype', 'cases', 'more'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mains = MainNav::all();
        return view('admin.CaseTypes.create', compact('mains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->all();
            switch ($data['case_type']) {
                case 'قضايا':
                    $casetype = CaseType::create([
                        'name' => $data['name'],
                        'added_by' => auth()->user()->id
                    ]);
                    NegligenceDays::create([
                        'case_type_id' => $casetype->id,
                        'days' => $data['days'],
                        'column_name' => $data['name'],
                    ]);
                    break;

                case 'قضايا تنفيذيه':
                    $excutiveCasesMain = excutiveCasesMain::create([
                        'name' => $data['name'],
                    ]);
                    NegligenceDays::create([
                        'excutive_cases_main_id' => $excutiveCasesMain->id,
                        'days' => $data['days'],
                        'column_name' => $data['name'],
                    ]);
                    break;

                case 'التسويات':
                    $settlement = SettlementMain::create([
                        'name' => $data['name'],
                    ]);
                    NegligenceDays::create([
                        'settlement_main_id' => $settlement->id,
                        'days' => $data['days'],
                        'column_name' => $data['name'],
                    ]);
                    break;

                case 'معاملات':
                    $transactionsMain = TransactionsMain::create([
                        'name' => $data['name'],
                    ]);
                    NegligenceDays::create([
                        'transactions_main_id' => $transactionsMain->id,
                        'days' => $data['days'],
                        'column_name' => $data['name'],
                    ]);
                    break;

                default:
                    $main = subNav::create([
                        'name' => $data['name'],
                        'main_nav_id' => $data['case_type'],
                    ]);
                    NegligenceDays::create([
                        'sub_nav_id' => $main->id,
                        'days' => $data['days'],
                        'column_name' => $data['name'],
                    ]);
                    break;
            }

            return redirect()->route('casetypes.index')->with(['success' => 'تم الحفظ بنجاح']);

        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with(["error" => 'عفواً حدث خطأ: ' . $th->getMessage()])->withInput();
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

    public function storeSettlement(Request $request, ExecutiveCase $casetype)
    {
        $data = $request->except('_token', 'lawsuit_type', 'lawsuit_number');
        $data['executive_case_id'] = $casetype->id;
        Settlement::create($data);
        return redirect()->route('cases.show', $case ?? '')->with('success', 'تم تسجيل التسوية بنجاح');
    }

    public function mains()
    {
        $main = MainNav::all();
        return view('admin.main.index', compact('main'));
    }

    public function mainStore()
    {
        $data = request()->except('_token');
        MainNav::create($data);
        return redirect()->route('MainTypes.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function mainDestroy(MainNav $main)
    {
        $main->delete();
        return redirect()->route('MainTypes.index')->with('success', 'تم حذف البيانات بنجاح');
    }

    public function navDestroy(subNav $nav)
    {
        $nav->delete();
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }
}
